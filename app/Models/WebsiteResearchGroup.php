<?php

namespace App\Models;

use App\Enums\ActiveStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class WebsiteResearchGroup extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => ActiveStatus::class,
        'spotlight' => 'array',
    ];

    public function researchers(): BelongsToMany
    {
        return $this->belongsToMany(WebsitePersonnel::class, 'website_research_group_researchers', 'research_group_id', 'personnel_id');
    }

    public function publications(): BelongsToMany
    {
        return $this->belongsToMany(WebsitePublication::class, 'website_research_group_publications', 'research_group_id', 'publication_id');
    }
}
