<?php
/**
 * File Path: app/Models/ContactSubmission.php
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'message',
        'status',
        'reply_subject',
        'reply_message',
        'replied_at',
        'replied_by',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'replied_at' => 'datetime',
    ];

    /**
     * Get the user who replied
     */
    public function repliedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    /**
     * Scope for new submissions
     */
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    /**
     * Scope for read submissions
     */
    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    /**
     * Scope for replied submissions
     */
    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    /**
     * Mark as read
     */
    public function markAsRead()
    {
        if ($this->status === 'new') {
            $this->update(['status' => 'read']);
        }
    }

    /**
     * Mark as replied
     */
    public function markAsReplied()
    {
        $this->update(['status' => 'replied']);
    }

    /**
     * Check if submission is new
     */
    public function isNew()
    {
        return $this->status === 'new';
    }

    /**
     * Check if submission has been replied to
     */
    public function hasBeenReplied(): bool
    {
        return $this->replied_at !== null;
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'new' => 'success',
            'read' => 'warning',
            'replied' => 'info',
            default => 'secondary',
        };
    }
}
