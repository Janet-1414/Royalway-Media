<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceView extends Model
{
    public $timestamps = false;

    protected $fillable = ['resource_id', 'visitor_hash', 'viewed_on'];

    protected $casts = [
        'viewed_on' => 'date',
    ];

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
