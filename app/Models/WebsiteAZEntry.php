<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\ActiveStatus;

class WebsiteAZEntry extends Model
{
    protected $table = 'website_a_z_entries'; // Explicitly set table name just in case
    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => ActiveStatus::class,
    ];
}
