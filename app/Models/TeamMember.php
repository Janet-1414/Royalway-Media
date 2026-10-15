<?php
/**
 * File Path: app/Models/TeamMember.php
 *
 * Run: php artisan make:model TeamMember
 * Then replace content with this file
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'photo',
        'bio',
        'email',
        'phone',
        'social_links',
        'order',
        'is_active',
    ];

    protected $casts = [
        'social_links' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Scope for active team members
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered team members
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    /**
     * Get social link by platform
     */
    public function getSocialLink($platform)
    {
        return $this->social_links[$platform] ?? null;
    }

    /**
     * Check if team member has a specific social platform
     */
    public function hasSocialLink($platform)
    {
        return isset($this->social_links[$platform]) && !empty($this->social_links[$platform]);
    }
}
