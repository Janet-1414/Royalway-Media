<?php

namespace Database\Factories;

use App\Models\EventBrief;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<EventBrief>
 */
class EventBriefFactory extends Factory
{
    protected $model = EventBrief::class;

    public function definition(): array
    {
        return [
            'organization_name' => fake()->company(),
            'key_contact' => fake()->name(),
            'email' => fake()->companyEmail(),
            'venue' => fake()->address(),
            'event_nature' => fake()->randomElement(['Conference', 'Workshop', 'Corporate Event', 'Launch', 'Gala']),
            'setup' => fake()->randomElement(['indoor', 'outdoor']),
            'guest_count' => fake()->randomElement(['less50', '50-70', '80-100', '100-200', '250above']),
            'venue_setup' => fake()->randomElements(['Venue Sourcing', 'Tents', 'Chairs', 'Stage/Platforms'], 2),
            'sound_visuals' => fake()->randomElements(['Sound/PA Systems', 'LED Screens', 'Photography'], 2),
            'decoration' => fake()->randomElements(['Draping', 'Table Linen', 'Flower centerpieces'], 2),
            'hospitality' => fake()->randomElements(['Photo Booth', 'Ushers', 'MC/Event Host Sourcing'], 1),
            'branding' => fake()->randomElements(['Media management', 'Branded materials'], 1),
            'additional_info' => fake()->optional()->paragraph(),
            'status' => 'new',
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
        ];
    }

    /**
     * Indicate that the brief has been replied to.
     */
    public function replied(): static
    {
        return $this->state(fn (array $attributes) => [
            'reply_subject' => 'Re: Your Event Brief',
            'reply_message' => fake()->paragraph(),
            'replied_at' => now(),
            'replied_by' => 1,
        ]);
    }
}
