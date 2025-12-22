<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Page;
use App\Models\Staff;
use App\Models\Student;
use App\Models\WebsiteNews;
use App\Models\WebsiteEvent;
use App\Models\WebsiteProgram;
use App\Models\WebsiteCourse;

class StaffDashboardController extends Controller
{
    public function index()
    {
        $staff = Auth::guard('staff')->user()->load([
            'staff_assigned_roles.role',
            'websiteRoles'
        ]);

        $stats = [];
        $recent_news = [];
        $isSuperAdmin = $staff->role == 1 || $staff->hasWebsiteRole('super-admin');
        $isEditor = $staff->hasWebsiteRole('editor');

        if ($isSuperAdmin) {
            $stats = [
                'pages' => Page::count(),
                'staff_count' => Staff::count(),
                'students' => Student::count(),
                'news' => WebsiteNews::count(),
                'events' => WebsiteEvent::count(),
                'programs' => WebsiteProgram::count(),
                'courses' => WebsiteCourse::count(),
            ];
            $recent_news = WebsiteNews::latest()->take(5)->get();
        } elseif ($isEditor) {
            $stats = [
                'pages' => Page::count(),
                'news' => WebsiteNews::count(),
                'events' => WebsiteEvent::count(),
            ];
            $recent_news = WebsiteNews::latest()->take(5)->get();
        }

        return view('dashboard.staff.index', compact('staff', 'stats', 'recent_news'));
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
