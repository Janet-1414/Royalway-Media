<?php

namespace Database\Factories;

use App\Models\ContactSubmission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContactSubmission>
 */
class ContactSubmissionFactory extends Factory
{
    protected $model = ContactSubmission::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'message' => fake()->paragraph(),
            'status' => 'new',
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
        ];
    }

    /**
     * Indicate that the submission has been replied to.
     */
    public function replied(): static
    {
        return $this->state(fn (array $attributes) => [
            'reply_subject' => 'Re: Your Inquiry',
            'reply_message' => fake()->paragraph(),
            'replied_at' => now(),
            'replied_by' => 1,
        ]);
    }
}
