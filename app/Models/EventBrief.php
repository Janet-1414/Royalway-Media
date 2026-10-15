<?php
/**
 * File Path: app/Models/EventBrief.php
 *
 * Run: php artisan make:model EventBrief
 * Then replace content with this file
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventBrief extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_name',
        'key_contact',
        'venue',
        'event_nature',
        'setup',
        'guest_count',
        'venue_setup',
        'sound_visuals',
        'decoration',
        'hospitality',
        'branding',
        'additional_info',
        'status',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'venue_setup' => 'array',
        'sound_visuals' => 'array',
        'decoration' => 'array',
        'hospitality' => 'array',
        'branding' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope for new submissions
     */
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    /**
     * Scope for reviewed submissions
     */
    public function scopeReviewed($query)
    {
        return $query->where('status', 'reviewed');
    }

    /**
     * Scope for quoted submissions
     */
    public function scopeQuoted($query)
    {
        return $query->where('status', 'quoted');
    }

    /**
     * Mark as reviewed
     */
    public function markAsReviewed()
    {
        $this->update(['status' => 'reviewed']);
    }

    /**
     * Mark as quoted
     */
    public function markAsQuoted()
    {
        $this->update(['status' => 'quoted']);
    }

    /**
     * Mark as confirmed
     */
    public function markAsConfirmed()
    {
        $this->update(['status' => 'confirmed']);
    }

    /**
     * Mark as completed
     */
    public function markAsCompleted()
    {
        $this->update(['status' => 'completed']);
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'new' => 'success',
            'reviewed' => 'info',
            'quoted' => 'warning',
            'confirmed' => 'primary',
            'completed' => 'secondary',
            default => 'secondary',
        };
    }

    /**
     * Get guest count label
     */
    public function getGuestCountLabelAttribute()
    {
        return match($this->guest_count) {
            'less50' => 'Less than 50 people',
            '50-70' => '50-70 people',
            '80-100' => '80-100 people',
            '100-200' => '100-200 people',
            '250above' => '250 and above',
            default => $this->guest_count,
        };
    }

    /**
     * Get all selected services as a formatted list
     */
    public function getAllSelectedServices()
    {
        $services = [];

        if ($this->venue_setup) {
            $services['Venue Setup'] = $this->venue_setup;
        }
        if ($this->sound_visuals) {
            $services['Sound & Visuals'] = $this->sound_visuals;
        }
        if ($this->decoration) {
            $services['Decoration'] = $this->decoration;
        }
        if ($this->hospitality) {
            $services['Hospitality & Entertainment'] = $this->hospitality;
        }
        if ($this->branding) {
            $services['Branding & Communication'] = $this->branding;
        }

        return $services;
    }
}
