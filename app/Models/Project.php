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
