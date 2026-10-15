<?php
/**
 * File Path: app/Mail/EventBriefConfirmationMail.php
 *
 * Run: php artisan make:mail EventBriefConfirmationMail
 * Then replace content with this file
 */

namespace App\Mail;

use App\Models\EventBrief;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventBriefConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $brief;

    /**
     * Create a new message instance.
     */
    public function __construct(EventBrief $brief)
    {
        $this->brief = $brief;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Event Brief Received - RoyalWay Media',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.event-brief-confirmation',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
