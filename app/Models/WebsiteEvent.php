<?php

namespace App\Models;

use App\Enums\ActiveStatus;
use Illuminate\Database\Eloquent\Model;

class WebsiteEvent extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => ActiveStatus::class,
        'start_date_and_time' => 'datetime',
        'end_date_and_time' => 'datetime',
    ];
}
