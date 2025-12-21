<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    protected $table = 'website_pages';

    protected $fillable = [
        'title',
        'slug',
        'meta_title',
        'meta_description',
        'is_active',
    ];

    public function blocks()
    {
        return $this->hasMany(ContentBlock::class, 'page_id')->orderBy('order');
    }
}
