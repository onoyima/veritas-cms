<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Enums\PageStatus;
use App\Enums\ActiveStatus;
use App\Enums\FeatureStatus;
use Illuminate\Validation\Rules\Enum;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // For Super Admin, show all pages
        // For Editors, show only pages they created or are assigned to (if we had assignment logic)
        // For now, we assume Staff with 'editor' role can see all pages but maybe with limited actions
        
        $pages = Page::with(['creator', 'approver'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('dashboard.admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:website_pages,slug',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'status' => ['nullable', new Enum(PageStatus::class)],
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
            'is_featured' => ['nullable', new Enum(FeatureStatus::class)],
        ]);

        // Auto-generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        // Ensure slug is unique if auto-generated
        if (Page::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $validated['slug'] . '-' . uniqid();
        }

        // Set defaults if null
        $validated['status'] = $validated['status'] ?? PageStatus::DRAFT->value;
        $validated['is_active'] = $validated['is_active'] ?? ActiveStatus::ACTIVE->value;
        $validated['is_featured'] = $validated['is_featured'] ?? FeatureStatus::STANDARD->value;
        
        $validated['created_by'] = auth()->guard('staff')->id();
        
        // Handle publishing timestamp
        if ($validated['status'] === PageStatus::PUBLISHED->value) {
            $validated['published_at'] = now();
            // Auto-approve if super admin
            if (auth()->guard('staff')->user()->hasWebsiteRole('super-admin') || auth()->guard('staff')->user()->role == 1) {
                $validated['approved_by'] = auth()->guard('staff')->id();
            }
        }

        Page::create($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $page = Page::findOrFail($id);
        return view('dashboard.admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $page = Page::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:website_pages,slug,' . $id,
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'status' => ['nullable', new Enum(PageStatus::class)],
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
            'is_featured' => ['nullable', new Enum(FeatureStatus::class)],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        // Handle Status Changes & Approval Logic
        if (isset($validated['status']) && $validated['status'] !== $page->status->value) {
            // If changing to published
            if ($validated['status'] === PageStatus::PUBLISHED->value) {
                // Check if user has permission to publish (Super Admin)
                if (auth()->guard('staff')->user()->hasWebsiteRole('super-admin') || auth()->guard('staff')->user()->role == 1) {
                    $validated['published_at'] = now();
                    $validated['approved_by'] = auth()->guard('staff')->id();
                } else {
                    // Non-admins cannot publish directly, set to pending
                    $validated['status'] = PageStatus::PENDING->value;
                }
            }
        }

        $page->update($validated);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus(string $id)
    {
        $page = Page::findOrFail($id);
        
        $user = auth()->guard('staff')->user();
        $isAdmin = $user->hasWebsiteRole('super-admin') || $user->role == 1;

        if ($page->status === PageStatus::PUBLISHED) {
            $page->update(['status' => PageStatus::DRAFT]);
            $message = 'Page unpublished (moved to Draft).';
        } else {
            // Publishing
            if ($isAdmin) {
                $page->update([
                    'status' => PageStatus::PUBLISHED,
                    'published_at' => now(),
                    'approved_by' => $user->id
                ]);
                $message = 'Page published successfully.';
            } else {
                $page->update(['status' => PageStatus::PENDING]);
                $message = 'Page submitted for approval.';
            }
        }

        return back()->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $page = Page::findOrFail($id);
        $page->delete();

        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully.');
    }
}
