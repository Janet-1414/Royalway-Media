<?php
/**
 * File Path: app/Http/Controllers/ResourceController.php
 */

namespace App\Http\Controllers;

use App\Models\PageHero;
use App\Models\Project;
use App\Models\Resource as ResourceModel;
use App\Models\ResourceReaction;
use App\Services\SpamGuard;
use App\Services\Visitor;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /**
     * The old Resources listing now lives on two pages. Send visitors to the right one.
     */
    public function index(Request $request)
    {
        $params = array_filter(['search' => $request->input('search')]);

        if ($request->input('type') === 'communication_asset') {
            return redirect()->route('assets.index', $params, 301);
        }

        return redirect()->route('insights.index', $params, 301);
    }

    /**
     * Display the News & Insights page (published resources of type "blog")
     */
    public function insights(Request $request)
    {
        $base = ResourceModel::published()->blogs();
        $search = trim((string) $request->input('search'));
        $topic = trim((string) $request->input('topic'));
        $filtering = $search !== '' || $topic !== '';

        $topics = (clone $base)
            ->whereNotNull('topic')
            ->where('topic', '!=', '')
            ->distinct()
            ->orderBy('topic')
            ->pluck('topic');

        // Lead story and headline stack only on the unfiltered page
        $lead = null;
        $headlines = collect();

        if (! $filtering) {
            $lead = (clone $base)->where('is_featured', true)->latest('published_at')->latest('id')->first()
                ?? (clone $base)->latest('published_at')->latest('id')->first();

            if ($lead) {
                $headlines = (clone $base)
                    ->where('id', '!=', $lead->id)
                    ->latest('published_at')
                    ->latest('id')
                    ->limit(4)
                    ->get();
            }
        }

        $query = clone $base;

        if ($topic !== '') {
            $query->where('topic', $topic);
        }

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('excerpt', 'like', '%' . $search . '%')
                    ->orWhere('author', 'like', '%' . $search . '%')
                    ->orWhere('topic', 'like', '%' . $search . '%');
            });
        }

        if ($lead) {
            $query->whereNotIn('id', $headlines->pluck('id')->push($lead->id));
        }

        $posts = $query->latest('published_at')->latest('id')->paginate(9)->withQueryString();

        $hero = PageHero::forKey('insights');

        return view('insights.index', compact('posts', 'lead', 'headlines', 'topics', 'search', 'topic', 'hero'));
    }

    /**
     * Display the Communication Assets page
     */
    public function assets(Request $request)
    {
        $base = ResourceModel::published()->communicationAssets();
        $search = trim((string) $request->input('search'));
        $format = (string) $request->input('format');
        $projectSlug = trim((string) $request->input('project'));

        $query = (clone $base)->with('projects:id,title,slug');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('excerpt', 'like', '%' . $search . '%');
            });
        }

        if (array_key_exists($format, ResourceModel::FILE_GROUP_LABELS)) {
            $query->fileGroup($format);
        } else {
            $format = '';
        }

        $activeProject = null;
        if ($projectSlug !== '') {
            $activeProject = Project::published()->where('slug', $projectSlug)->first(['id', 'title', 'slug']);
            $query->whereHas('projects', fn ($q) => $q->where('projects.slug', $projectSlug));
        }

        $assets = $query->latest('published_at')->latest('id')->paginate(12)
            ->appends($request->except(['page', 'preview']));

        // Projects that have at least one published asset, for the filter
        $projects = Project::published()
            ->whereHas('communicationAssets', fn ($q) => $q->where('is_published', true))
            ->orderBy('title')
            ->get(['id', 'title', 'slug']);

        // Shareable preview link: ?preview=slug
        $previewAsset = null;
        if ($request->filled('preview')) {
            $previewAsset = (clone $base)->where('slug', $request->input('preview'))->first();
        }

        $hero = PageHero::forKey('assets');

        return view('assets.index', compact('assets', 'projects', 'activeProject', 'search', 'format', 'previewAsset', 'hero'));
    }

    /**
     * Display the specified article or asset
     */
    public function show(Request $request, $slug)
    {
        $resource = ResourceModel::where('slug', $slug)
            ->published()
            ->publicTypes()
            ->firstOrFail();

        $relatedResources = ResourceModel::published()
            ->where('type', $resource->type)
            ->where('id', '!=', $resource->id)
            ->latest('published_at')
            ->latest('id')
            ->limit(3)
            ->get();

        $reactionsEnabled = setting('insights_reactions_enabled', '1') === '1';
        $commentsEnabled = setting('insights_comments_enabled', '0') === '1' && $resource->allow_comments;

        $reactionCounts = $reactionsEnabled ? ResourceReaction::countsFor($resource->id) : [];
        $myReaction = null;
        if ($reactionsEnabled && ($visitorHash = Visitor::reactionHash($request, false))) {
            $myReaction = ResourceReaction::where('resource_id', $resource->id)
                ->where('visitor_hash', $visitorHash)
                ->value('type');
        }

        $comments = $commentsEnabled ? $resource->approvedComments()->get() : collect();

        return view('resources.show', compact(
            'resource',
            'relatedResources',
            'reactionsEnabled',
            'commentsEnabled',
            'reactionCounts',
            'myReaction',
            'comments'
        ) + ['formTimestamp' => SpamGuard::generateTimestamp()]);
    }
}
