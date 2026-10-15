<?php
/**
 * File Path: app/Http/Controllers/EventBriefController.php
 *
 * Run: php artisan make:controller EventBriefController
 * Then replace content with this file
 */

namespace App\Http\Controllers;

use App\Models\EventBrief;
use App\Mail\EventBriefSubmissionMail;
use App\Mail\EventBriefConfirmationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EventBriefController extends Controller
{
    /**
     * Display the event brief form
     */
    public function index()
    {
        return view('event-brief');
    }

    /**
     * Handle event brief form submission
     */
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'organization_name' => 'required|string|max:255',
            'key_contact' => 'required|string|max:255',
            'venue' => 'required|string|max:255',
            'event_nature' => 'required|string|max:255',
            'setup' => 'required|in:indoor,outdoor',
            'guest_count' => 'required|string',
            'venue_setup' => 'nullable|array',
            'sound_visuals' => 'nullable|array',
            'decoration' => 'nullable|array',
            'hospitality' => 'nullable|array',
            'branding' => 'nullable|array',
            'additional_info' => 'nullable|string|max:5000',
        ]);

        // Create the event brief
        $brief = EventBrief::create([
            'organization_name' => $validated['organization_name'],
            'key_contact' => $validated['key_contact'],
            'venue' => $validated['venue'],
            'event_nature' => $validated['event_nature'],
            'setup' => $validated['setup'],
            'guest_count' => $validated['guest_count'],
            'venue_setup' => $validated['venue_setup'] ?? [],
            'sound_visuals' => $validated['sound_visuals'] ?? [],
            'decoration' => $validated['decoration'] ?? [],
            'hospitality' => $validated['hospitality'] ?? [],
            'branding' => $validated['branding'] ?? [],
            'additional_info' => $validated['additional_info'] ?? null,
            'status' => 'new',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Send email notification to admin
        try {
            Mail::to(config('mail.admin_email', 'sales@royalwaymedia.com'))
                ->send(new EventBriefSubmissionMail($brief));

            // Send confirmation email to user (if we have their email in key_contact)
            // You might want to add an email field to the form
            // Mail::to($userEmail)->send(new EventBriefConfirmationMail($brief));
        } catch (\Exception $e) {
            // Log the error but don't fail the submission
            \Log::error('Failed to send event brief email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Thank you for submitting your event brief! We will contact you shortly with a quote.');
    }
}
