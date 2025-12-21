<?php

namespace App\Models;

use App\Enums\ActiveStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WebsitePersonnel extends Model
{
    protected $table = 'website_personnel';
    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => ActiveStatus::class,
        'biography' => 'array',
    ];

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(WebsiteCourse::class, 'website_course_personnel', 'personnel_id', 'course_id');
    }

    public function publications(): BelongsToMany
    {
        return $this->belongsToMany(WebsitePublication::class, 'website_personnel_publications', 'personnel_id', 'publication_id');
    }

    public function researchGroups(): BelongsToMany
    {
        return $this->belongsToMany(WebsiteResearchGroup::class, 'website_research_group_researchers', 'personnel_id', 'research_group_id');
    }
}
