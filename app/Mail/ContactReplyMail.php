<?php

namespace App\Mail;

use App\Models\ContactSubmission;
use App\Models\EventBrief;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactReplyMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public string $recipientName;
    public string $replySubject;
    public string $replyMessage;
    public string $originalContent;
    public string $originalLabel;

    /**
     * Create a new message instance.
     */
    public function __construct(
        string $recipientName,
        string $replySubject,
        string $replyMessage,
        string $originalContent,
        string $originalLabel = 'Your original message'
    ) {
        $this->recipientName = $recipientName;
        $this->replySubject = $replySubject;
        $this->replyMessage = $replyMessage;
        $this->originalContent = $originalContent;
        $this->originalLabel = $originalLabel;
    }

    /**
     * Create from ContactSubmission
     */
    public static function fromContactSubmission(ContactSubmission $submission): self
    {
        return new self(
            $submission->name,
            $submission->reply_subject,
            $submission->reply_message,
            $submission->message,
            'Your original message'
        );
    }

    /**
     * Create from EventBrief
     */
    public static function fromEventBrief(EventBrief $brief): self
    {
        $summary = "Organization: {$brief->organization_name}\n";
        $summary .= "Event: {$brief->event_nature}\n";
        $summary .= "Venue: {$brief->venue}\n";
        $summary .= "Setup: " . ucfirst($brief->setup) . "\n";
        $summary .= "Guests: {$brief->guest_count_label}";

        if ($brief->additional_info) {
            $summary .= "\n\nAdditional Info:\n{$brief->additional_info}";
        }

        return new self(
            $brief->key_contact,
            $brief->reply_subject,
            $brief->reply_message,
            $summary,
            'Your event brief summary'
        );
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->replySubject,
            replyTo: [config('mail.admin_email', 'sales@royalwaymedia.com')],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-reply',
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
