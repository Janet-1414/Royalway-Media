<?php
/**
 * File Path: app/Models/Policy.php
 *
 * Run: php artisan make:model Policy
 * Then replace content with this file
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Policy extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'badge_text',
        'content',
        'hero_image',
        'sidebar_image',
        'contact_info',
        'effective_date',
        'version',
        'is_published',
        'order',
    ];

    protected $casts = [
        'contact_info' => 'array',
        'effective_date' => 'date',
        'is_published' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Boot method to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($policy) {
            if (empty($policy->slug)) {
                $policy->slug = Str::slug($policy->title);
            }
        });

        static::updating(function ($policy) {
            if ($policy->isDirty('title') && empty($policy->slug)) {
                $policy->slug = Str::slug($policy->title);
            }
        });
    }

    /**
     * Scope for published policies
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope for ordered policies
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
     * Get formatted effective date
     */
    public function getFormattedEffectiveDateAttribute()
    {
        return $this->effective_date ? $this->effective_date->format('F d, Y') : null;
    }

    /**
     * Hero background: the uploaded image, or the default banner from assets/img when unset or missing
     */
    public function getHeroImageUrlAttribute(): string
    {
        if (filled($this->hero_image) && file_exists(storage_path('app/public/' . $this->hero_image))) {
            return asset('storage/' . $this->hero_image);
        }

        return asset('assets/img/breadcramb.png');
    }

    /**
     * Get contact info value
     */
    public function getContactInfoValue($key)
    {
        return $this->contact_info[$key] ?? null;
    }
}
