<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageHero extends Model
{
    protected $fillable = ['key', 'heading', 'intro', 'image'];

    /**
     * Pages that have an editable hero, with their admin tab label
     */
    public const PAGES = [
        'insights' => 'News & Insights',
        'assets' => 'Communication Assets',
        'policies' => 'Policies',
    ];

    /**
     * The hero row for a page, created with the default wording on first use
     */
    public static function forKey(string $key): self
    {
        return static::firstOrCreate(['key' => $key], static::defaults()[$key] ?? []);
    }

    /**
     * Public URL of the uploaded image, or null if it is missing
     */
    public function getImageUrlAttribute(): ?string
    {
        if (empty($this->image) || ! file_exists(storage_path('app/public/' . $this->image))) {
            return null;
        }

        return asset('storage/' . $this->image);
    }

    public static function defaults(): array
    {
        return [
            'insights' => [
                'heading' => 'Ideas. Perspectives. Insights.',
                'intro' => 'Explore ideas, expert perspectives and industry insights on strategic communications, public relations, marketing, branding and the evolving landscape of business and development across Africa.',
            ],
            'assets' => [
                'heading' => 'Stories you can see, share and use.',
                'intro' => 'Browse the reports, campaign materials, visuals and media we have created with our partners. Preview anything right here, then download what you need.',
            ],
            'policies' => [
                'heading' => 'How we work, openly.',
                'intro' => 'Integrity, care and accountability guide every partnership we build. Here you will find the commitments that shape how we serve our clients, our people and our communities.',
            ],
        ];
    }
}
