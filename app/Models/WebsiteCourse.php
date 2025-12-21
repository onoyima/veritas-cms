<?php

namespace App\Models;

use App\Enums\ActiveStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WebsiteCourse extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => ActiveStatus::class,
    ];

    public function programs(): HasMany
    {
        return $this->hasMany(WebsiteProgram::class, 'course_id');
    }

    public function personnel(): BelongsToMany
    {
        return $this->belongsToMany(WebsitePersonnel::class, 'website_course_personnel', 'course_id', 'personnel_id');
    }
}
