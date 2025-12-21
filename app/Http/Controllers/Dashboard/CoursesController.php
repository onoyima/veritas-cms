<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\WebsiteCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Enums\ActiveStatus;
use Illuminate\Validation\Rules\Enum;

class CoursesController extends Controller
{
    public function index()
    {
        $courses = WebsiteCourse::orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('dashboard.admin.courses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:website_courses,slug',
            'faculty' => 'nullable|string|max:255',
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['course_name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $validated['is_active'] = $validated['is_active'] ?? ActiveStatus::ACTIVE->value;

        WebsiteCourse::create($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
    }

    public function edit(WebsiteCourse $course)
    {
        return view('dashboard.admin.courses.edit', compact('course'));
    }

    public function update(Request $request, WebsiteCourse $course)
    {
        $validated = $request->validate([
            'course_name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:website_courses,slug,' . $course->id,
            'faculty' => 'nullable|string|max:255',
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['course_name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $validated['is_active'] = $validated['is_active'] ?? ActiveStatus::INACTIVE->value;

        $course->update($validated);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(WebsiteCourse $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully.');
    }
}
