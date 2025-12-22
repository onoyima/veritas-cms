<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\WebsiteResearchGroup;
use App\Models\WebsitePersonnel;
use App\Models\WebsitePublication;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Enums\ActiveStatus;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Facades\Storage;

class ResearchGroupsController extends Controller
{
    public function index()
    {
        $groups = WebsiteResearchGroup::orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.admin.research-groups.index', compact('groups'));
    }

    public function create()
    {
        $personnel = WebsitePersonnel::orderBy('name')->get();
        $publications = WebsitePublication::orderBy('title1')->get();
        return view('dashboard.admin.research-groups.create', compact('personnel', 'publications'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:website_research_groups,slug',
            'image' => 'nullable|image|max:2048',
            'spotlight' => 'nullable|string',
            'spotlight_url' => 'nullable|url',
            'spotlight_image_file' => 'nullable|image|max:2048',
            
            'research_focus_title1' => 'nullable|string|max:255',
            'research_focus_content1' => 'nullable|string',
            'research_focus_image1' => 'nullable|image|max:2048',
            
            'research_focus_title2' => 'nullable|string|max:255',
            'research_focus_content2' => 'nullable|string',
            'research_focus_image2' => 'nullable|image|max:2048',
            
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
            
            'personnel_ids' => 'nullable|array',
            'personnel_ids.*' => 'exists:website_personnel,id',
            'publication_ids' => 'nullable|array',
            'publication_ids.*' => 'exists:website_publications,id',
        ]);

        // Handle Slug
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        // Handle File Uploads
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/research-groups', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        if ($request->hasFile('spotlight_image_file')) {
            $path = $request->file('spotlight_image_file')->store('uploads/research-groups/spotlights', 'public');
            $validated['spotlight_image'] = '/storage/' . $path;
        }

        if ($request->hasFile('research_focus_image1')) {
            $path = $request->file('research_focus_image1')->store('uploads/research-groups/focus', 'public');
            $validated['research_focus_image_url1'] = '/storage/' . $path;
        }

        if ($request->hasFile('research_focus_image2')) {
            $path = $request->file('research_focus_image2')->store('uploads/research-groups/focus', 'public');
            $validated['research_focus_image_url2'] = '/storage/' . $path;
        }

        $validated['is_active'] = $validated['is_active'] ?? ActiveStatus::ACTIVE->value;

        $group = WebsiteResearchGroup::create($validated);

        // Sync Relationships
        if (isset($validated['personnel_ids'])) {
            $group->researchers()->sync($validated['personnel_ids']);
        }
        
        if (isset($validated['publication_ids'])) {
            $group->publications()->sync($validated['publication_ids']);
        }

        return redirect()->route('admin.research-groups.index')->with('success', 'Research Group created successfully.');
    }

    public function edit(WebsiteResearchGroup $researchGroup)
    {
        $personnel = WebsitePersonnel::orderBy('first_name')->get();
        $publications = WebsitePublication::orderBy('title1')->get();
        $group = $researchGroup;
        return view('dashboard.admin.research-groups.edit', compact('group', 'personnel', 'publications'));
    }

    public function update(Request $request, WebsiteResearchGroup $researchGroup)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:website_research_groups,slug,' . $researchGroup->id,
            'image' => 'nullable|image|max:2048',
            'spotlight' => 'nullable|string',
            'spotlight_url' => 'nullable|url',
            'spotlight_image_file' => 'nullable|image|max:2048',
            
            'research_focus_title1' => 'nullable|string|max:255',
            'research_focus_content1' => 'nullable|string',
            'research_focus_image1' => 'nullable|image|max:2048',
            
            'research_focus_title2' => 'nullable|string|max:255',
            'research_focus_content2' => 'nullable|string',
            'research_focus_image2' => 'nullable|image|max:2048',
            
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
            
            'personnel_ids' => 'nullable|array',
            'personnel_ids.*' => 'exists:website_personnel,id',
            'publication_ids' => 'nullable|array',
            'publication_ids.*' => 'exists:website_publications,id',
        ]);

        // Handle Slug
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        // Handle File Uploads
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/research-groups', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        if ($request->hasFile('spotlight_image_file')) {
            $path = $request->file('spotlight_image_file')->store('uploads/research-groups/spotlights', 'public');
            $validated['spotlight_image'] = '/storage/' . $path;
        }

        if ($request->hasFile('research_focus_image1')) {
            $path = $request->file('research_focus_image1')->store('uploads/research-groups/focus', 'public');
            $validated['research_focus_image_url1'] = '/storage/' . $path;
        }

        if ($request->hasFile('research_focus_image2')) {
            $path = $request->file('research_focus_image2')->store('uploads/research-groups/focus', 'public');
            $validated['research_focus_image_url2'] = '/storage/' . $path;
        }

        $validated['is_active'] = $validated['is_active'] ?? ActiveStatus::INACTIVE->value;

        $researchGroup->update($validated);

        // Sync Relationships
        if (isset($validated['personnel_ids'])) {
            $researchGroup->researchers()->sync($validated['personnel_ids']);
        } else {
            $researchGroup->researchers()->detach();
        }
        
        if (isset($validated['publication_ids'])) {
            $researchGroup->publications()->sync($validated['publication_ids']);
        } else {
            $researchGroup->publications()->detach();
        }

        return redirect()->route('admin.research-groups.index')->with('success', 'Research Group updated successfully.');
    }

    public function destroy(WebsiteResearchGroup $researchGroup)
    {
        $researchGroup->delete();
        return redirect()->route('admin.research-groups.index')->with('success', 'Research Group deleted successfully.');
    }
}
