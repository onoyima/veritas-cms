<?php

namespace App\Models;

use App\Enums\ActiveStatus;
use Illuminate\Database\Eloquent\Model;

class WebsiteNews extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => ActiveStatus::class,
        'published_at' => 'datetime',
        'overview' => 'array',
        'content' => 'array',
    ];
}
