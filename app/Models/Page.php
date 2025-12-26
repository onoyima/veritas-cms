<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\PageStatus;
use App\Enums\ActiveStatus;
use App\Enums\FeatureStatus;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'website_pages';

    protected $fillable = [
        'title',
        'slug',
        'meta_title',
        'meta_description',
        'is_active',
        'status',
        'is_featured',
        'published_at',
        'created_by',
        'approved_by',
        'content',
        'image_url',
    ];

    protected $casts = [
        'is_active' => ActiveStatus::class,
        'status' => PageStatus::class,
        'is_featured' => FeatureStatus::class,
        'published_at' => 'datetime',
        'content' => 'array',
    ];

    public function blocks()
    {
        return $this->hasMany(ContentBlock::class, 'page_id')->orderBy('order');
    }

    public function creator()
    {
        return $this->belongsTo(Staff::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(Staff::class, 'approved_by');
    }
}
