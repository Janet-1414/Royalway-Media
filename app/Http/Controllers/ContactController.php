<?php
/**
 * File Path: app/Http/Controllers/ContactController.php
 */

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use App\Mail\ContactSubmissionMail;
use App\Mail\ContactConfirmationMail;
use App\Services\SpamGuard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Display the contact page
     */
    public function index()
    {
        return view('contact', [
            'formTimestamp' => SpamGuard::generateTimestamp(),
        ]);
    }

    /**
     * Handle contact form submission
     */
    public function store(Request $request)
    {
        // Spam check BEFORE validation/saving
        $spamGuard = new SpamGuard($request, 'contact', ['name', 'message']);

        if ($spamGuard->isSpam()) {
            // Silent drop - return success message but do nothing
            return redirect()->back()->with('success', 'Thank you for your message! We will get back to you shortly.');
        }

        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // Create the submission
        $submission = ContactSubmission::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'],
            'status' => 'new',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Send email notification to admin
        try {
            Mail::to(config('mail.admin_email', 'sales@royalwaymedia.com'))
                ->send(new ContactSubmissionMail($submission));

            // Send confirmation email to user
            Mail::to($submission->email)
                ->send(new ContactConfirmationMail($submission));
        } catch (\Exception $e) {
            // Log the error but don't fail the submission
            \Log::error('Failed to send contact email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Thank you for your message! We will get back to you shortly.');
    }
}
