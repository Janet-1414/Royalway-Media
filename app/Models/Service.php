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
use Illuminate\Support\Str;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'category',
        'headline',
        'intro',
        'checklist',
        'short_description',
        'full_description',
        'icon',
        'image',
        'poster_image',
        'gallery',
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
}
