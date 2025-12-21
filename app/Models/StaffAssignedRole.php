<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffAssignedRole extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'role_id',
        'assigner_role_id',
        'assigned_by',
        'removed_by',
        'assigned_date',
        'level',
        'removed_date',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
