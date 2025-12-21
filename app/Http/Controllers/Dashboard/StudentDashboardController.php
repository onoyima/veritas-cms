<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user()->load([
            'student_academic'
        ]);

        return view('dashboard.student.index', compact('student'));
    }

    public function profile()
    {
        $student = Auth::guard('student')->user()->load([
            'student_academic',
            'student_contact',
            'student_medical'
        ]);

        return view('dashboard.student.profile', compact('student'));
    }
}
