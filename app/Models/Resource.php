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
        'topic',
        'excerpt',
        'content',
        'file',
        'featured_image',
        'show_cover',
        'author',
        'is_published',
        'is_featured',
        'allow_comments',
        'published_at',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'show_cover' => 'boolean',
        'is_featured' => 'boolean',
        'allow_comments' => 'boolean',
        'views_count' => 'integer',
        'published_at' => 'date',
    ];

    /**
     * Types shown on the public site. Old "publication" and "other" rows stay
     * in the database but are never listed or opened publicly.
     */
    public const PUBLIC_TYPES = ['blog', 'communication_asset'];

    /**
     * Type labels for the admin
     */
    public const TYPE_LABELS = [
        'blog' => 'News & Insights',
        'communication_asset' => 'Communication Asset',
    ];

    /**
     * File extensions grouped by the filter on the Communication Assets page
     */
    public const FILE_GROUPS = [
        'documents' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'csv', 'txt'],
        'images' => ['jpg', 'jpeg', 'png', 'webp', 'gif'],
        'media' => ['mp4', 'webm', 'mp3'],
    ];

    public const FILE_GROUP_LABELS = [
        'documents' => 'Documents',
        'images' => 'Images',
        'media' => 'Video and audio',
        'other' => 'Other',
    ];

    /**
     * Upload formats accepted in the admin, by MIME type
     */
    public const UPLOAD_MIME_TYPES = [
        'application/pdf',
        'image/jpeg',
        'image/png',
        'image/webp',
        'image/gif',
        'application/msword',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'application/vnd.ms-powerpoint',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'text/csv',
        'text/plain',
        'video/mp4',
        'video/webm',
        'audio/mpeg',
    ];

    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }

    public function views()
    {
        return $this->hasMany(ResourceView::class);
    }

    public function reactions()
    {
        return $this->hasMany(ResourceReaction::class);
    }

    public function comments()
    {
        return $this->hasMany(ResourceComment::class);
    }

    public function approvedComments()
    {
        return $this->hasMany(ResourceComment::class)->where('status', 'approved')->oldest();
    }

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
     * Scope for the types allowed on the public site
     */
    public function scopePublicTypes($query)
    {
        return $query->whereIn('type', self::PUBLIC_TYPES);
    }

    /**
     * Scope for a file type group on the Communication Assets page
     */
    public function scopeFileGroup($query, string $group)
    {
        if (isset(self::FILE_GROUPS[$group])) {
            return $query->where(function ($q) use ($group) {
                foreach (self::FILE_GROUPS[$group] as $ext) {
                    $q->orWhereRaw('LOWER(file) LIKE ?', ['%.' . $ext]);
                }
            });
        }

        if ($group === 'other') {
            return $query->where(function ($q) {
                $q->whereNull('file')->orWhere('file', '');
                $q->orWhere(function ($q) {
                    foreach (array_merge(...array_values(self::FILE_GROUPS)) as $ext) {
                        $q->whereRaw('LOWER(file) NOT LIKE ?', ['%.' . $ext]);
                    }
                });
            });
        }

        return $query;
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
     * Estimated reading time in minutes, from the content word count
     */
    public function getReadingTimeAttribute(): int
    {
        $words = str_word_count(strip_tags(html_entity_decode((string) $this->content)));

        return max(1, (int) ceil($words / 200));
    }

    /**
     * Admin label for the type
     */
    public function getTypeLabelAttribute(): string
    {
        return self::TYPE_LABELS[$this->type] ?? ucfirst(str_replace('_', ' ', (string) $this->type));
    }

    /**
     * Lower case extension of the attached file
     */
    public function getFileExtensionAttribute(): ?string
    {
        return $this->file ? strtolower(pathinfo($this->file, PATHINFO_EXTENSION)) : null;
    }

    /**
     * Public URL of the attached file, or null if it is missing
     */
    public function getFileUrlAttribute(): ?string
    {
        if (empty($this->file) || ! file_exists(storage_path('app/public/' . $this->file))) {
            return null;
        }

        return asset('storage/' . $this->file);
    }

    /**
     * File type group: documents, images, media or other
     */
    public function getFileGroupAttribute(): string
    {
        foreach (self::FILE_GROUPS as $group => $extensions) {
            if (in_array($this->file_extension, $extensions, true)) {
                return $group;
            }
        }

        return 'other';
    }

    /**
     * How the file can be previewed: pdf, image, video, audio, office, text or none
     */
    public function getPreviewKindAttribute(): string
    {
        return match ($this->file_extension) {
            'pdf' => 'pdf',
            'jpg', 'jpeg', 'png', 'webp', 'gif' => 'image',
            'mp4', 'webm' => 'video',
            'mp3' => 'audio',
            'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx' => 'office',
            'txt' => 'text',
            default => 'none',
        };
    }

    /**
     * Short badge for the file type, for example PDF or DOCX
     */
    public function getFileBadgeAttribute(): ?string
    {
        return $this->file_extension ? strtoupper($this->file_extension) : null;
    }

    /**
     * Font Awesome icon for the file type
     */
    public function getFileIconAttribute(): string
    {
        return match ($this->file_extension) {
            'pdf' => 'fa-file-pdf',
            'doc', 'docx' => 'fa-file-word',
            'xls', 'xlsx', 'csv' => 'fa-file-excel',
            'ppt', 'pptx' => 'fa-file-powerpoint',
            'jpg', 'jpeg', 'png', 'webp', 'gif' => 'fa-file-image',
            'mp4', 'webm' => 'fa-file-video',
            'mp3' => 'fa-file-audio',
            'txt' => 'fa-file-lines',
            default => 'fa-file',
        };
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
