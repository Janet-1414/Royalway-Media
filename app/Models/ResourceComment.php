<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResourceComment extends Model
{
    public const STATUSES = [
        'pending' => 'Pending',
        'approved' => 'Approved',
        'spam' => 'Spam',
    ];

    protected $fillable = ['resource_id', 'name', 'email', 'body', 'status', 'ip_hash'];

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
