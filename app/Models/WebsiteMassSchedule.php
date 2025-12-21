<?php

namespace App\Models;

use App\Enums\ActiveStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteMassSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'day',
        'start_time',
        'end_time',
        'invitees',
        'is_active',
    ];

    protected $casts = [
        'invitees' => 'array',
        'is_active' => ActiveStatus::class,
    ];
}
