<?php

namespace App\Models;

use App\Enums\ActiveStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WebsiteProgram extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => ActiveStatus::class,
        'program_description' => 'array',
        'eligibility_criteria' => 'array',
        'how_to_apply' => 'array',
        'financial_aid' => 'array',
        'research_facilities' => 'array',
        'transfer_candidates' => 'array',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(WebsiteCourse::class, 'course_id');
    }
}
