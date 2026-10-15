<?php

namespace App\Services;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Crypt;

class SpamGuard
{
    protected Request $request;
    protected string $formType;
    protected array $textFields;

    public function __construct(Request $request, string $formType, array $textFields = [])
    {
        $this->request = $request;
        $this->formType = $formType;
        $this->textFields = $textFields;
    }

    /**
     * Run all spam checks. Returns true if spam, false if clean.
     */
    public function isSpam(): bool
    {
        // Check honeypot
        if ($this->failsHoneypot()) {
            $this->logSpam('honeypot');
            return true;
        }

        // Check timing
        if ($this->failsTiming()) {
            $this->logSpam('timing');
            return true;
        }

        // Check rate limit
        if ($this->failsRateLimit()) {
            $this->logSpam('rate_limit');
            return true;
        }

        // Check reCAPTCHA
        if ($this->failsRecaptcha()) {
            $this->logSpam('recaptcha');
            return true;
        }

        // Check content rules
        if ($this->failsContentRules()) {
            $this->logSpam('content_rules');
            return true;
        }

        // Check blocked domain
        if ($this->failsBlockedDomain()) {
            $this->logSpam('blocked_domain');
            return true;
        }

        return false;
    }

    /**
     * Check if honeypot field is filled
     */
    protected function failsHoneypot(): bool
    {
        $honeypot = $this->request->input('website');
        return !empty($honeypot);
    }

    /**
     * Check if form was submitted too quickly
     */
    protected function failsTiming(): bool
    {
        $formStartedAt = $this->request->input('form_started_at');

        if (empty($formStartedAt)) {
            return true;
        }

        try {
            $timestamp = Crypt::decryptString($formStartedAt);
            $startTime = (int) $timestamp;
            $elapsed = time() - $startTime;

            return $elapsed < 3;
        } catch (\Exception $e) {
            return true;
        }
    }

    /**
     * Check rate limit
     */
    protected function failsRateLimit(): bool
    {
        $key = 'spam_guard:' . $this->formType . ':' . $this->request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return true;
        }

        RateLimiter::hit($key, 3600); // 1 hour
        return false;
    }

    /**
     * Check reCAPTCHA v3
     */
    protected function failsRecaptcha(): bool
    {
        $secretKey = config('services.recaptcha.secret_key');

        // Skip if not configured (local dev)
        if (empty($secretKey)) {
            return false;
        }

        $token = $this->request->input('g-recaptcha-response');

        if (empty($token)) {
            return true;
        }

        try {
            $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secretKey,
                'response' => $token,
                'remoteip' => $this->request->ip(),
            ]);

            if (!$response->successful()) {
                // Network error - fail open but log
                Log::warning('SpamGuard: reCAPTCHA network error', [
                    'form' => $this->formType,
                    'ip' => $this->request->ip(),
                ]);
                return false;
            }

            $data = $response->json();

            if (!($data['success'] ?? false)) {
                return true;
            }

            // Check action matches
            $expectedAction = $this->formType === 'contact' ? 'contact' : 'event_brief';
            if (($data['action'] ?? '') !== $expectedAction) {
                return true;
            }

            // Check score
            $minScore = config('services.recaptcha.min_score', 0.5);
            if (($data['score'] ?? 0) < $minScore) {
                return true;
            }

            return false;
        } catch (\Exception $e) {
            // Fail open on errors but log
            Log::warning('SpamGuard: reCAPTCHA exception', [
                'form' => $this->formType,
                'ip' => $this->request->ip(),
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Check content rules
     */
    protected function failsContentRules(): bool
    {
        $combinedText = '';
        $name = '';

        foreach ($this->textFields as $field) {
            $value = $this->request->input($field, '');
            $combinedText .= ' ' . $value;
            if ($field === 'name' || $field === 'key_contact') {
                $name = $value;
            }
        }

        $combinedText = trim($combinedText);

        // Check if message is only digits/whitespace
        if (preg_match('/^[\d\s]+$/', $combinedText) && strlen($combinedText) > 5) {
            return true;
        }

        // Check for non-Latin script (more than 30%)
        if ($this->hasExcessiveNonLatin($combinedText)) {
            return true;
        }

        // Check for more than 2 URLs
        if ($this->countUrls($combinedText) > 2) {
            return true;
        }

        // Check blocked words/phrases
        if ($this->containsBlockedWords($combinedText)) {
            return true;
        }

        // Check name for vowels and length
        if (!empty($name)) {
            if (strlen($name) > 60) {
                return true;
            }
            // Name with no vowels (allow short names like "Mr X")
            if (strlen($name) > 3 && !preg_match('/[aeiouAEIOU]/u', $name)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if email domain is blocked
     */
    protected function failsBlockedDomain(): bool
    {
        $email = $this->request->input('email');

        if (empty($email)) {
            return false;
        }

        $domain = strtolower(substr(strrchr($email, '@'), 1));

        if (empty($domain)) {
            return false;
        }

        $blockedDomains = $this->getBlockedDomains();

        return in_array($domain, $blockedDomains, true);
    }

    /**
     * Check if text has excessive non-Latin characters
     */
    protected function hasExcessiveNonLatin(string $text): bool
    {
        // Remove spaces and punctuation for counting
        $lettersOnly = preg_replace('/[^a-zA-Z\p{L}]/u', '', $text);

        if (strlen($lettersOnly) < 10) {
            return false;
        }

        // Count Latin letters
        $latinCount = preg_match_all('/[a-zA-Z]/', $lettersOnly);

        // Count non-Latin letters (Cyrillic, Greek, Arabic, Armenian, CJK, etc.)
        $nonLatinPattern = '/[\p{Cyrillic}\p{Greek}\p{Arabic}\p{Armenian}\p{Hebrew}\p{Han}\p{Hangul}\p{Hiragana}\p{Katakana}\p{Thai}]/u';
        $nonLatinCount = preg_match_all($nonLatinPattern, $lettersOnly);

        $totalLetters = mb_strlen($lettersOnly);

        if ($totalLetters === 0) {
            return false;
        }

        return ($nonLatinCount / $totalLetters) > 0.3;
    }

    /**
     * Count URLs in text
     */
    protected function countUrls(string $text): int
    {
        $pattern = '/(https?:\/\/|www\.)[^\s]+/i';
        return preg_match_all($pattern, $text);
    }

    /**
     * Check if text contains blocked words/phrases
     */
    protected function containsBlockedWords(string $text): bool
    {
        $blockedWords = $this->getBlockedWords();
        $textLower = strtolower($text);

        foreach ($blockedWords as $word) {
            if (stripos($textLower, strtolower($word)) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get blocked words from settings
     */
    protected function getBlockedWords(): array
    {
        $setting = SiteSetting::get('spam_blocked_words', '');
        return array_filter(array_map('trim', explode("\n", $setting)));
    }

    /**
     * Get blocked domains from settings
     */
    protected function getBlockedDomains(): array
    {
        $setting = SiteSetting::get('spam_blocked_domains', '');
        return array_filter(array_map('strtolower', array_map('trim', explode("\n", $setting))));
    }

    /**
     * Log spam detection
     */
    protected function logSpam(string $reason): void
    {
        Log::info('SpamGuard blocked submission', [
            'form' => $this->formType,
            'reason' => $reason,
            'ip' => $this->request->ip(),
        ]);
    }

    /**
     * Generate encrypted timestamp for timing check
     */
    public static function generateTimestamp(): string
    {
        return Crypt::encryptString((string) time());
    }
}
