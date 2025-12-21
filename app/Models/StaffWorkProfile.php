<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffWorkProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'staff_no',
        'staff_type_id',
        'faculty_id',
        'department_id',
        'admin_department_id',
        'staff_position_id',
        'appointment_date',
        'assumption_date',
        'employment_category_id',
        'grade', // veritas
        'step_id',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }


    public function auxiliary_staff()
    {
        return $this->hasMany(AuxiliaryStaff::class, 'staff_id', 'staff_id');
    }

    public function stafftype()
    {
        return $this->belongsTo(StaffType::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function admin_department()
    {
        return $this->belongsTo(AdminDepartment::class);
    }

    public function staff_position()
    {
        return $this->belongsTo(StaffPosition::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function assigned_courses()
    {
        return $this->hasMany(AssignedCourse::class, 'staff_id', 'staff_id');
    }

    public function appointment_termination()
    {
        return $this->hasOne(AppointmentTermination::class, 'staff_id', 'staff_id');
    }


    public function staff_leave_summaries()
    {
        return $this->hasMany(StaffLeaveSummary::class, 'staff_id', 'staff_id');
    }

    public function staff_promotions()
    {
        return $this->hasMany(StaffPromotion::class, 'staff_id', 'staff_id');
    }

    public function employment_category()
    {

        return $this->belongsTo(EmploymentCategory::class);
    }


    public function staff_employment_categories()
    {
        return $this->hasMany(StaffEmploymentCategory::class, 'staff_id', 'staff_id');
    }
}
