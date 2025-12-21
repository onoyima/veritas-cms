<?php

namespace App\Models;

use App\Enums\ActiveStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WebsitePublication extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => ActiveStatus::class,
    ];

    public function personnel(): BelongsToMany
    {
        return $this->belongsToMany(WebsitePersonnel::class, 'website_personnel_publications', 'publication_id', 'personnel_id');
    }

    public function researchGroups(): BelongsToMany
    {
        return $this->belongsToMany(WebsiteResearchGroup::class, 'website_research_group_publications', 'publication_id', 'research_group_id');
    }
}
