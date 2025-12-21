<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\ActiveStatus;

class WebsiteFaq extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => ActiveStatus::class,
    ];
}
