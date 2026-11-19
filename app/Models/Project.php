<?php
/**
 * File Path: app/Models/Project.php
 *
 * Run: php artisan make:model Project
 * Then replace content with this file
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'client',
        'client_logo',
        'partner_id',
        'description',
        'lead',
        'challenge',
        'narrative_blocks',
        'side_card_title',
        'side_card_items',
        'headline_stats',
        'results',
        'result_channels',
        'result_kpis',
        'results_footnote',
        'outcome_text',
        'featured_image',
        'gallery',
        'videos',
        'category',
        'location',
        'tags',
        'is_featured',
        'is_published',
        'project_date',
        'download_link',
        'report_url',
        'summary_pdf',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'gallery' => 'array',
        'videos' => 'array',
        'narrative_blocks' => 'array',
        'side_card_items' => 'array',
        'headline_stats' => 'array',
        'result_channels' => 'array',
        'result_kpis' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'project_date' => 'date',
    ];

    public function partner()
    {
        return $this->belongsTo(Partner::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class);
    }

    public function communicationAssets()
    {
        return $this->belongsToMany(Resource::class)->where('type', 'communication_asset');
    }

    /**
     * Boot method to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            if (empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });

        static::updating(function ($project) {
            if ($project->isDirty('title') && empty($project->slug)) {
                $project->slug = Str::slug($project->title);
            }
        });
    }

    /**
     * Scope for published projects
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope for featured projects
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope for filtering by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get formatted project date
     */
    public function getFormattedDateAttribute()
    {
        return $this->project_date ? $this->project_date->format('F Y') : null;
    }

    /**
     * Get safe image URL - returns null if file doesn't exist
     */
    public function getImageUrlAttribute()
    {
        if (empty($this->featured_image)) {
            return null;
        }
        $path = storage_path('app/public/' . $this->featured_image);
        if (!file_exists($path)) {
            return null;
        }
        return asset('storage/' . $this->featured_image);
    }

    /**
     * Check if project has results data (variant A)
     */
    public function getHasResultsDataAttribute()
    {
        return !empty($this->result_channels) || !empty($this->result_kpis);
    }

    /**
     * Project Videos repeater rows ready to render: title, original url, and the embed from videoEmbed()
     */
    public function getVideoItemsAttribute(): array
    {
        $items = [];

        // A row saved as an encoded JSON string comes back from the array cast as a string, so decode it
        $videos = $this->videos;
        while (is_string($videos) && $videos !== '') {
            $decoded = json_decode($videos, true);
            if ($decoded === null) {
                break;
            }
            $videos = $decoded;
        }

        foreach (is_array($videos) ? $videos : [] as $video) {
            $embed = self::videoEmbed(is_array($video) ? ($video['url'] ?? null) : null);
            if ($embed) {
                $items[] = ['title' => trim((string) ($video['title'] ?? ''))] + $embed;
            }
        }

        return $items;
    }

    /**
     * Turn a pasted video URL into something renderable:
     * ['type' => 'iframe'|'video'|'link', 'src' => ..., 'url' => original, 'mime' => for video only].
     * Returns null for an empty or non-http(s) URL.
     */
    public static function videoEmbed(?string $url): ?array
    {
        $url = trim((string) $url);
        if ($url === '' || !preg_match('~^https?://~i', $url)) {
            return null;
        }

        $iframe = fn (string $src) => ['type' => 'iframe', 'src' => $src, 'url' => $url];

        // YouTube: watch?v=, youtu.be/, /shorts/, /embed/, /live/
        if (preg_match('~(?:youtube(?:-nocookie)?\.com/(?:watch\?(?:.*&)?v=|embed/|shorts/|live/|v/)|youtu\.be/)([A-Za-z0-9_-]{11})~i', $url, $m)) {
            return $iframe('https://www.youtube-nocookie.com/embed/' . $m[1] . '?rel=0');
        }

        // Vimeo, including unlisted links that carry a privacy hash (vimeo.com/123/abc123)
        if (preg_match('~vimeo\.com/(?:video/|channels/[^/]+/|groups/[^/]+/videos/)?(\d+)(?:/([A-Za-z0-9]+))?~i', $url, $m)) {
            return $iframe('https://player.vimeo.com/video/' . $m[1] . (!empty($m[2]) ? '?h=' . $m[2] : ''));
        }

        // Dailymotion: dailymotion.com/video/ID or dai.ly/ID
        if (preg_match('~(?:dailymotion\.com/(?:embed/)?video/|dai\.ly/)([A-Za-z0-9]+)~i', $url, $m)) {
            return $iframe('https://www.dailymotion.com/embed/video/' . $m[1]);
        }

        // Facebook: /videos/, /watch?v=, /reel/, fb.watch short links; the plugin takes the page URL itself
        if (preg_match('~^https?://(?:(?:www|m|web)\.)?(?:facebook\.com/(?:.+/videos/|watch/?\?(?:.*&)?v=|reel/|video\.php\?)|fb\.watch/)~i', $url)) {
            return $iframe('https://www.facebook.com/plugins/video.php?href=' . rawurlencode($url) . '&show_text=false');
        }

        // Direct video files play in a <video> tag
        $path = strtolower((string) parse_url($url, PHP_URL_PATH));
        if (str_ends_with($path, '.mp4') || str_ends_with($path, '.webm')) {
            return ['type' => 'video', 'src' => $url, 'url' => $url, 'mime' => str_ends_with($path, '.webm') ? 'video/webm' : 'video/mp4'];
        }

        return ['type' => 'link', 'src' => $url, 'url' => $url];
    }

    /**
     * Get client initials for monogram fallback
     */
    public function getClientInitialsAttribute()
    {
        if (empty($this->client)) {
            return 'RW';
        }
        $words = explode(' ', $this->client);
        $initials = '';
        foreach (array_slice($words, 0, 2) as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        return $initials ?: 'RW';
    }
}
