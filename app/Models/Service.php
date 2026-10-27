<?php
/**
 * File Path: app/Models/Service.php
 *
 * Run: php artisan make:model Service
 * Then replace content with this file
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    /**
     * Cache key for the navbar services dropdown
     */
    public const NAV_CACHE_KEY = 'nav_services';

    protected $fillable = [
        'title',
        'slug',
        'tagline',
        'category',
        'headline',
        'intro',
        'checklist',
        'short_description',
        'full_description',
        'content',
        'features',
        'icon',
        'image',
        'poster_image',
        'gallery',
        'offer_background_image',
        'video_url',
        'order',
        'is_active',
        'is_featured',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'order' => 'integer',
        'checklist' => 'array',
        'gallery' => 'array',
        'features' => 'array',
    ];

    /**
     * Boot method to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($service) {
            if (empty($service->slug)) {
                $service->slug = Str::slug($service->title);
            }
        });

        static::updating(function ($service) {
            if ($service->isDirty('title') && empty($service->slug)) {
                $service->slug = Str::slug($service->title);
            }
        });

        // Refresh the navbar services dropdown after admin edits
        static::saved(fn () => Cache::forget(self::NAV_CACHE_KEY));
        static::deleted(fn () => Cache::forget(self::NAV_CACHE_KEY));
    }

    /**
     * Scope for active services
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered services
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Scope for featured services
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get the projects associated with this service
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    /**
     * Get safe image URL - returns null if file doesn't exist
     */
    public function getImageUrlAttribute()
    {
        if (empty($this->image)) {
            return null;
        }
        $path = storage_path('app/public/' . $this->image);
        if (!file_exists($path)) {
            return null;
        }
        return asset('storage/' . $this->image);
    }

    /**
     * Get safe poster image URL
     */
    public function getPosterImageUrlAttribute()
    {
        if (empty($this->poster_image)) {
            return null;
        }
        $path = storage_path('app/public/' . $this->poster_image);
        if (!file_exists($path)) {
            return null;
        }
        return asset('storage/' . $this->poster_image);
    }

    /**
     * Background for the What We Offer section: the image uploaded in Filament only, null if none
     */
    public function getOfferBackgroundUrlAttribute(): ?string
    {
        $path = $this->offer_background_image;

        if (is_string($path) && $path !== '' && file_exists(storage_path('app/public/' . $path))) {
            return asset('storage/' . $path);
        }

        return null;
    }

    /**
     * YouTube / Vimeo embed URL built from video_url, or null if unrecognised
     */
    public function getVideoEmbedUrlAttribute(): ?string
    {
        $url = trim((string) $this->video_url);
        if ($url === '') {
            return null;
        }

        if (preg_match('~(?:youtube(?:-nocookie)?\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/)|youtu\.be/)([A-Za-z0-9_-]{11})~', $url, $m)) {
            return 'https://www.youtube-nocookie.com/embed/' . $m[1] . '?rel=0';
        }

        if (preg_match('~vimeo\.com/(?:video/|channels/[^/]+/|groups/[^/]+/videos/)?(\d+)~', $url, $m)) {
            return 'https://player.vimeo.com/video/' . $m[1];
        }

        return null;
    }

    /**
     * Hero slideshow images: gallery first, falling back to poster then card image
     */
    public function getHeroImagesAttribute(): array
    {
        $paths = array_filter((array) ($this->gallery ?? []));
        if (empty($paths)) {
            $paths = array_filter([$this->poster_image, $this->image]);
        }

        $urls = [];
        foreach ($paths as $path) {
            if (is_string($path) && file_exists(storage_path('app/public/' . $path))) {
                $urls[] = asset('storage/' . $path);
            }
        }

        return array_values(array_unique($urls));
    }

    /**
     * "What We Offer" cards from the features repeater
     */
    public function getOfferItemsAttribute(): array
    {
        $items = [];

        foreach ((array) ($this->features ?? []) as $feature) {
            $title = trim(is_array($feature) ? ($feature['title'] ?? '') : (string) $feature);
            if ($title !== '') {
                $items[] = [
                    'title' => $title,
                    'description' => is_array($feature) ? trim($feature['description'] ?? '') : '',
                ];
            }
        }

        return $items;
    }

    /**
     * Non-empty Checklist Items tags
     */
    public function getChecklistItemsAttribute(): array
    {
        return array_values(array_filter(
            array_map(fn ($item) => trim((string) $item), (array) ($this->checklist ?? [])),
            fn ($item) => $item !== ''
        ));
    }

    /**
     * Split extended content into a CTA heading (its first line) and the remaining body html.
     * Returns null when there is no visible content.
     */
    public static function splitCta(?string $html): ?array
    {
        $html = trim((string) $html);
        if (trim(strip_tags($html)) === '') {
            return null;
        }

        $toText = fn ($fragment) => trim(preg_replace('/\s+/', ' ', html_entity_decode(strip_tags($fragment), ENT_QUOTES | ENT_HTML5)));

        // Plain text: first line is the heading
        if (strip_tags($html) === $html) {
            $lines = preg_split('/\R/', $html, 2);
            $rest = trim($lines[1] ?? '');

            return ['heading' => trim($lines[0]), 'body' => $rest !== '' ? nl2br(e($rest)) : null];
        }

        // Rich text: first block element is the heading, or its text up to the first <br>
        if (preg_match('~^<(h[1-6]|p|div)\b[^>]*>(.*?)</\1>(.*)$~is', $html, $m)) {
            $parts = preg_split('~<br\s*/?>~i', $m[2], 2);
            $rest = trim($m[3]);
            if (isset($parts[1]) && $toText($parts[1]) !== '') {
                $rest = '<p>' . trim($parts[1]) . '</p>' . $rest;
            }
            $heading = $toText($parts[0]);
        } else {
            $parts = preg_split('~<br\s*/?>|</(?:p|div|h[1-6])>~i', $html, 2);
            $heading = $toText($parts[0]);
            $rest = trim($parts[1] ?? '');
        }

        if ($heading === '') {
            return self::splitCta($rest);
        }

        return ['heading' => $heading, 'body' => trim(strip_tags($rest)) !== '' ? $rest : null];
    }
}
