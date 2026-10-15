<?php

namespace Tests\Feature;

use App\Services\SpamGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\RateLimiter;
use Tests\TestCase;

class SpamGuardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Clear rate limiter before each test
        RateLimiter::clear('spam_guard:contact:127.0.0.1');
        // Disable reCAPTCHA for unit tests
        config(['services.recaptcha.secret_key' => null]);
    }

    protected function createSpamGuard(array $data, string $formType = 'contact', array $textFields = ['name', 'message']): SpamGuard
    {
        $request = Request::create('/contact', 'POST', $data, [], [], [
            'REMOTE_ADDR' => '127.0.0.1',
        ]);
        return new SpamGuard($request, $formType, $textFields);
    }

    public function test_it_passes_when_honeypot_is_empty(): void
    {
        $timestamp = Crypt::encryptString((string) (time() - 10));

        $spamGuard = $this->createSpamGuard([
            'website' => '',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Hello, I need help with my project.',
            'form_started_at' => $timestamp,
        ]);

        $this->assertFalse($spamGuard->isSpam());
    }

    public function test_it_fails_when_honeypot_is_filled(): void
    {
        $timestamp = Crypt::encryptString((string) (time() - 10));

        $spamGuard = $this->createSpamGuard([
            'website' => 'http://spam.com',
            'name' => 'Spammer',
            'email' => 'spam@spam.com',
            'message' => 'Buy now!',
            'form_started_at' => $timestamp,
        ]);

        $this->assertTrue($spamGuard->isSpam());
    }

    public function test_it_passes_timing_check_for_normal_submissions(): void
    {
        // Create a timestamp from 10 seconds ago
        $timestamp = Crypt::encryptString((string) (time() - 10));

        $spamGuard = $this->createSpamGuard([
            'website' => '',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Hello, I need help with my project.',
            'form_started_at' => $timestamp,
        ]);

        $this->assertFalse($spamGuard->isSpam());
    }

    public function test_it_fails_timing_check_for_instant_submissions(): void
    {
        // Create a timestamp from 1 second ago (too fast)
        $timestamp = Crypt::encryptString((string) (time() - 1));

        $spamGuard = $this->createSpamGuard([
            'website' => '',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'message' => 'Test message',
            'form_started_at' => $timestamp,
        ]);

        $this->assertTrue($spamGuard->isSpam());
    }

    public function test_it_fails_timing_check_with_invalid_token(): void
    {
        $spamGuard = $this->createSpamGuard([
            'website' => '',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'message' => 'Test message',
            'form_started_at' => 'invalid_token',
        ]);

        $this->assertTrue($spamGuard->isSpam());
    }

    public function test_it_fails_timing_check_with_missing_token(): void
    {
        $spamGuard = $this->createSpamGuard([
            'website' => '',
            'name' => 'Test User',
            'email' => 'test@example.com',
            'message' => 'Test message',
            // No form_started_at
        ]);

        $this->assertTrue($spamGuard->isSpam());
    }

    public function test_it_fails_content_rules_for_digits_only_message(): void
    {
        $timestamp = Crypt::encryptString((string) (time() - 10));

        // Test with digits-only content across all text fields
        $spamGuard = $this->createSpamGuard([
            'website' => '',
            'name' => '12345',
            'email' => 'test@example.com',
            'message' => '1234567890 12345',
            'form_started_at' => $timestamp,
        ]);

        $this->assertTrue($spamGuard->isSpam());
    }

    public function test_it_passes_content_rules_for_normal_message(): void
    {
        $timestamp = Crypt::encryptString((string) (time() - 10));

        $spamGuard = $this->createSpamGuard([
            'website' => '',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Hello, I am interested in your PR services for my company. Could you please send me more information?',
            'form_started_at' => $timestamp,
        ]);

        $this->assertFalse($spamGuard->isSpam());
    }

    public function test_it_fails_content_rules_for_too_many_urls(): void
    {
        $timestamp = Crypt::encryptString((string) (time() - 10));

        $spamGuard = $this->createSpamGuard([
            'website' => '',
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'message' => 'Check out https://spam1.com and https://spam2.com and also http://spam3.com for great deals!',
            'form_started_at' => $timestamp,
        ]);

        $this->assertTrue($spamGuard->isSpam());
    }

    public function test_it_generates_valid_form_timestamp(): void
    {
        $timestamp = SpamGuard::generateTimestamp();

        $this->assertNotEmpty($timestamp);

        // Should be able to decrypt it
        $decrypted = Crypt::decryptString($timestamp);
        $this->assertIsNumeric($decrypted);
        $this->assertEqualsWithDelta(time(), (int) $decrypted, 5);
    }

    public function test_it_fails_for_name_longer_than_60_characters(): void
    {
        $timestamp = Crypt::encryptString((string) (time() - 10));

        $spamGuard = $this->createSpamGuard([
            'website' => '',
            'name' => str_repeat('A', 65),
            'email' => 'test@example.com',
            'message' => 'Hello, this is a valid message.',
            'form_started_at' => $timestamp,
        ]);

        $this->assertTrue($spamGuard->isSpam());
    }

    public function test_it_fails_for_name_without_vowels(): void
    {
        $timestamp = Crypt::encryptString((string) (time() - 10));

        $spamGuard = $this->createSpamGuard([
            'website' => '',
            'name' => 'BCDFGHJKL',  // No vowels and longer than 3 chars
            'email' => 'test@example.com',
            'message' => 'Hello, this is a valid message.',
            'form_started_at' => $timestamp,
        ]);

        $this->assertTrue($spamGuard->isSpam());
    }
}
