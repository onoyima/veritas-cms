<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\ActiveStatus;

class ContentBlock extends Model
{
    use HasFactory;

    protected $table = 'website_content_blocks';

    protected $fillable = [
        'page_id',
        'type',
        'identifier',
        'content',
        'order',
        'is_active',
    ];

    protected $casts = [
        'content' => 'array',
        'is_active' => ActiveStatus::class,
    ];

    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }
}
