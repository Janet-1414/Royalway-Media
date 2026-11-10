<?php
/**
 * File Path: app/Http/Controllers/ResourceEngagementController.php
 *
 * Readership, reactions and comments for News & Insights articles
 */

namespace App\Http\Controllers;

use App\Mail\ResourceCommentMail;
use App\Models\Resource as ResourceModel;
use App\Models\ResourceComment;
use App\Models\ResourceReaction;
use App\Services\SpamGuard;
use App\Services\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class ResourceEngagementController extends Controller
{
    /**
     * Most reactions accepted from one network per article. Limits repeat
     * reactions from a visitor who keeps clearing cookies.
     */
    protected const MAX_REACTIONS_PER_IP = 5;

    /**
     * Record one view per visitor per day. Called by a small beacon request
     * from the article page so it also works behind page caching.
     */
    public function view(Request $request, string $slug)
    {
        if (Visitor::isBot($request) || Visitor::isAdmin()) {
            return response()->noContent();
        }

        $resource = $this->findResource($slug);

        $inserted = DB::table('resource_views')->insertOrIgnore([
            'resource_id' => $resource->id,
            'visitor_hash' => Visitor::viewHash($request),
            'viewed_on' => now()->toDateString(),
        ]);

        if ($inserted) {
            $resource->newQuery()->whereKey($resource->id)->increment('views_count');
        }

        return response()->noContent();
    }

    /**
     * Add, change or remove the visitor's reaction. Sending the current
     * reaction again removes it.
     */
    public function react(Request $request, string $slug)
    {
        abort_unless(setting('insights_reactions_enabled', '1') === '1', 404);

        $validated = $request->validate([
            'type' => ['required', Rule::in(array_keys(ResourceReaction::TYPES))],
        ]);

        $resource = $this->findResource($slug);
        $visitorHash = Visitor::reactionHash($request);
        $ipHash = Visitor::ipHash($request);

        $existing = ResourceReaction::where('resource_id', $resource->id)
            ->where('visitor_hash', $visitorHash)
            ->first();

        $current = null;

        if ($existing && $existing->type === $validated['type']) {
            $existing->delete();
        } elseif ($existing) {
            $existing->update(['type' => $validated['type'], 'ip_hash' => $ipHash]);
            $current = $validated['type'];
        } else {
            $fromNetwork = ResourceReaction::where('resource_id', $resource->id)
                ->where('ip_hash', $ipHash)
                ->count();

            if ($fromNetwork >= self::MAX_REACTIONS_PER_IP) {
                return response()->json([
                    'message' => 'Thanks, your reaction has already been counted.',
                    'counts' => ResourceReaction::countsFor($resource->id),
                    'current' => null,
                ], 429);
            }

            ResourceReaction::create([
                'resource_id' => $resource->id,
                'visitor_hash' => $visitorHash,
                'ip_hash' => $ipHash,
                'type' => $validated['type'],
            ]);
            $current = $validated['type'];
        }

        return response()->json([
            'counts' => ResourceReaction::countsFor($resource->id),
            'current' => $current,
        ]);
    }

    /**
     * Store a comment. Every comment waits for approval in the admin.
     */
    public function comment(Request $request, string $slug)
    {
        $resource = $this->findResource($slug);

        abort_unless(
            setting('insights_comments_enabled', '0') === '1' && $resource->allow_comments,
            404
        );

        $back = redirect()->to(route('resources.show', $resource->slug) . '#comments');
        $thanks = 'Thank you. Your comment has been received and will appear once it has been reviewed.';

        $spamGuard = new SpamGuard($request, 'comment', ['name', 'body']);

        if ($spamGuard->isSpam()) {
            // Silent drop, same as the contact form
            return $back->with('comment_status', $thanks);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'body' => 'required|string|min:2|max:3000',
        ]);

        $comment = ResourceComment::create([
            'resource_id' => $resource->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'body' => $validated['body'],
            'status' => 'pending',
            'ip_hash' => Visitor::ipHash($request),
        ]);

        try {
            Mail::to(config('mail.admin_email', 'sales@royalwaymedia.com'))
                ->send(new ResourceCommentMail($comment));
        } catch (\Exception $e) {
            Log::error('Failed to send comment alert: ' . $e->getMessage());
        }

        return $back->with('comment_status', $thanks);
    }

    protected function findResource(string $slug): ResourceModel
    {
        return ResourceModel::where('slug', $slug)
            ->published()
            ->publicTypes()
            ->firstOrFail();
    }
}
