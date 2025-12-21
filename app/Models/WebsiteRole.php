<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteRole extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function permissions()
    {
        return $this->belongsToMany(WebsitePermission::class, 'website_role_permissions', 'role_id', 'permission_id');
    }

    public function staff()
    {
        return $this->belongsToMany(Staff::class, 'website_staff_roles', 'role_id', 'staff_id');
    }
}
