<?php
/**
 * File Path: app/Models/Resource.php
 *
 * Run: php artisan make:model Resource
 * Then replace content with this file
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'type',
        'excerpt',
        'content',
        'file',
        'featured_image',
        'show_cover',
        'author',
        'is_published',
        'published_at',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'show_cover' => 'boolean',
        'published_at' => 'date',
    ];

    /**
     * Boot method to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($resource) {
            if (empty($resource->slug)) {
                $resource->slug = Str::slug($resource->title);
            }
        });

        static::updating(function ($resource) {
            if ($resource->isDirty('title') && empty($resource->slug)) {
                $resource->slug = Str::slug($resource->title);
            }
        });
    }

    /**
     * Scope for published resources
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope for filtering by type
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for blogs
     */
    public function scopeBlogs($query)
    {
        return $query->where('type', 'blog');
    }

    /**
     * Scope for publications
     */
    public function scopePublications($query)
    {
        return $query->where('type', 'publication');
    }

    /**
     * Scope for communication assets
     */
    public function scopeCommunicationAssets($query)
    {
        return $query->where('type', 'communication_asset');
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get formatted published date
     */
    public function getFormattedPublishedDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('F d, Y') : null;
    }

    /**
     * Check if resource has downloadable file
     */
    public function hasFile()
    {
        return !empty($this->file);
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
}
