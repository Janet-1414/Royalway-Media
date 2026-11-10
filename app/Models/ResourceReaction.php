<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceReaction extends Model
{
    public const TYPES = [
        'like' => ['label' => 'Like', 'icon' => 'fa-thumbs-up'],
        'insightful' => ['label' => 'Insightful', 'icon' => 'fa-lightbulb'],
        'inspiring' => ['label' => 'Inspiring', 'icon' => 'fa-heart'],
    ];

    protected $fillable = ['resource_id', 'visitor_hash', 'ip_hash', 'type'];

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }

    /**
     * Reaction counts for one resource, with every type present
     */
    public static function countsFor(int $resourceId): array
    {
        $counts = static::where('resource_id', $resourceId)
            ->selectRaw('type, COUNT(*) as total')
            ->groupBy('type')
            ->pluck('total', 'type')
            ->all();

        return collect(array_keys(self::TYPES))
            ->mapWithKeys(fn ($type) => [$type => (int) ($counts[$type] ?? 0)])
            ->all();
    }
}
