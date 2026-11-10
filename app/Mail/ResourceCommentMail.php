<?php

namespace App\Mail;

use App\Models\ResourceComment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResourceCommentMail extends Mailable
{
    use Queueable, SerializesModels;

    public $comment;

    public function __construct(ResourceComment $comment)
    {
        $this->comment = $comment;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New comment waiting for approval - RoyalWay Media',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.resource-comment',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
