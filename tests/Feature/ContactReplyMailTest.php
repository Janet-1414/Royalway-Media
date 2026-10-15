<?php

namespace Tests\Feature;

use App\Mail\ContactReplyMail;
use App\Models\ContactSubmission;
use App\Models\EventBrief;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactReplyMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_reply_mail_can_be_created_from_contact_submission(): void
    {
        $submission = ContactSubmission::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Hello, I need help with marketing.',
            'reply_subject' => 'Re: Your Inquiry',
            'reply_message' => 'Thank you for reaching out. We would be happy to help.',
        ]);

        $mailable = ContactReplyMail::fromContactSubmission($submission);

        // Verify the mail is properly constructed
        $this->assertEquals($submission->reply_subject, $mailable->replySubject);
        $this->assertEquals($submission->name, $mailable->recipientName);
        $this->assertEquals($submission->reply_message, $mailable->replyMessage);
    }

    public function test_contact_reply_mail_can_be_created_from_event_brief(): void
    {
        $eventBrief = EventBrief::factory()->create([
            'organization_name' => 'Test Corp',
            'key_contact' => 'Jane Smith',
            'email' => 'jane@testcorp.com',
            'reply_subject' => 'Re: Your Event Brief',
            'reply_message' => 'We have received your event brief and will get back to you shortly.',
        ]);

        $mailable = ContactReplyMail::fromEventBrief($eventBrief);

        // Verify the mail is properly constructed
        $this->assertEquals($eventBrief->reply_subject, $mailable->replySubject);
        $this->assertEquals($eventBrief->key_contact, $mailable->recipientName);
        $this->assertEquals($eventBrief->reply_message, $mailable->replyMessage);
    }

    public function test_contact_reply_mail_renders_correctly(): void
    {
        $submission = ContactSubmission::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'message' => 'Original message content',
            'reply_subject' => 'Re: Test Subject',
            'reply_message' => 'This is the reply message.',
        ]);

        $mailable = ContactReplyMail::fromContactSubmission($submission);

        // Check that the mail can be rendered
        $rendered = $mailable->render();

        $this->assertStringContainsString('Test User', $rendered);
        $this->assertStringContainsString('This is the reply message.', $rendered);
        $this->assertStringContainsString('Original message content', $rendered);
    }

    public function test_contact_submission_can_track_reply_status(): void
    {
        $user = User::factory()->create();

        $submission = ContactSubmission::factory()->create([
            'reply_subject' => null,
            'reply_message' => null,
            'replied_at' => null,
            'replied_by' => null,
        ]);

        $this->assertFalse($submission->hasBeenReplied());

        $submission->update([
            'reply_subject' => 'Re: Inquiry',
            'reply_message' => 'Thank you for contacting us.',
            'replied_at' => now(),
            'replied_by' => $user->id,
        ]);

        $submission->refresh();

        $this->assertTrue($submission->hasBeenReplied());
        $this->assertEquals($user->id, $submission->replied_by);
        $this->assertNotNull($submission->replied_at);
    }

    public function test_event_brief_can_track_reply_status(): void
    {
        $user = User::factory()->create();

        $eventBrief = EventBrief::factory()->create([
            'email' => 'client@company.com',
            'reply_subject' => null,
            'reply_message' => null,
            'replied_at' => null,
            'replied_by' => null,
        ]);

        $this->assertFalse($eventBrief->hasBeenReplied());

        $eventBrief->update([
            'reply_subject' => 'Re: Event Brief',
            'reply_message' => 'We will contact you shortly.',
            'replied_at' => now(),
            'replied_by' => $user->id,
        ]);

        $eventBrief->refresh();

        $this->assertTrue($eventBrief->hasBeenReplied());
    }

    public function test_mail_is_queued_when_sent(): void
    {
        Mail::fake();

        $submission = ContactSubmission::factory()->create([
            'name' => 'Queue Test',
            'email' => 'queue@example.com',
            'message' => 'Test message',
            'reply_subject' => 'Re: Test',
            'reply_message' => 'Queued reply',
        ]);

        $mailable = ContactReplyMail::fromContactSubmission($submission);

        Mail::to($submission->email)->queue($mailable);

        Mail::assertQueued(ContactReplyMail::class, function ($mail) use ($submission) {
            return $mail->hasTo($submission->email);
        });
    }
}
