<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\WebsiteStudentGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Enums\ActiveStatus;
use Illuminate\Validation\Rules\Enum;

class StudentGroupsController extends Controller
{
    public function index()
    {
        $groups = WebsiteStudentGroup::orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.admin.student-groups.index', compact('groups'));
    }

    public function create()
    {
        return view('dashboard.admin.student-groups.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:website_student_groups,slug',
            'description' => 'nullable|string|max:255',
            'member_count' => 'nullable|string|max:50',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|string',
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/student-groups', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        $validated['is_active'] = $validated['is_active'] ?? ActiveStatus::ACTIVE->value;

        WebsiteStudentGroup::create($validated);

        return redirect()->route('admin.student-groups.index')->with('success', 'Student Group created successfully.');
    }

    public function edit(WebsiteStudentGroup $studentGroup)
    {
        return view('dashboard.admin.student-groups.edit', compact('studentGroup'));
    }

    public function update(Request $request, WebsiteStudentGroup $studentGroup)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:website_student_groups,slug,' . $studentGroup->id,
            'description' => 'nullable|string|max:255',
            'member_count' => 'nullable|string|max:50',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|string',
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/student-groups', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        $validated['is_active'] = $validated['is_active'] ?? ActiveStatus::INACTIVE->value;

        $studentGroup->update($validated);

        return redirect()->route('admin.student-groups.index')->with('success', 'Student Group updated successfully.');
    }

    public function destroy(WebsiteStudentGroup $studentGroup)
    {
        $studentGroup->delete();
        return redirect()->route('admin.student-groups.index')->with('success', 'Student Group deleted successfully.');
    }
}
