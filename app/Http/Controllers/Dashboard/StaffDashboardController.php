<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Page;
use App\Models\Staff;
use App\Models\Student;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $staff = Auth::guard('staff')->user()->load([
            'staff_assigned_roles.role',
            'websiteRoles'
        ]);

        $stats = [];
        if ($staff->role == 1 || $staff->hasWebsiteRole('super-admin')) {
            $stats = [
                'pages' => Page::count(),
                'staff_count' => Staff::count(),
                'students' => Student::count(),
            ];
        }

        return view('dashboard.staff.index', compact('staff', 'stats'));
    }

    public function profile()
    {
        $staff = Auth::guard('staff')->user()->load([
            'staff_contact',
            'staff_assigned_roles.role',
            'websiteRoles',
            'staff_work_profile'
        ]);

        return view('dashboard.staff.profile', compact('staff'));
    }
}
