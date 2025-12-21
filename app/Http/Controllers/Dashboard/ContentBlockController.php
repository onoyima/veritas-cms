<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ContentBlock;
use App\Models\Page;
use Illuminate\Http\Request;

use App\Enums\ActiveStatus;

class ContentBlockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Page $page)
    {
        $blocks = $page->blocks()->orderBy('order')->get();
        return view('dashboard.admin.blocks.index', compact('page', 'blocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Page $page)
    {
        return view('dashboard.admin.blocks.create', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Page $page)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'identifier' => 'nullable|string',
            'order' => 'integer',
            'content' => 'nullable', // Allow string (JSON) or array
            'is_active' => 'boolean',
            'images.*' => 'image|max:2048', // Handle image uploads
        ]);

        $content = $validated['content'] ?? [];

        // If content is a JSON string (from Create form), decode it
        if (is_string($content)) {
            $content = json_decode($content, true) ?? [];
        }

        // Handle Image Uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $file) {
                $path = $file->store('uploads/blocks', 'public');
                $content[$key] = '/storage/' . $path;
            }
        }

        $validated['content'] = $content;
        $validated['page_id'] = $page->id;
        $validated['is_active'] = $request->has('is_active') ? ActiveStatus::ACTIVE : ActiveStatus::INACTIVE;

        ContentBlock::create($validated);

        return redirect()->route('admin.pages.blocks.index', $page->id)->with('success', 'Block added successfully.');
    }

    // ... show ...

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContentBlock $block)
    {
        return view('dashboard.admin.blocks.edit', compact('block'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContentBlock $block)
    {
        $validated = $request->validate([
            'type' => 'required|string',
            'identifier' => 'nullable|string',
            'order' => 'integer',
            'content' => 'nullable|array',
            'content_json' => 'nullable|string', // Raw JSON fallback
            'use_json' => 'nullable|boolean',
            'images.*' => 'image|max:2048',
        ]);

        $currentContent = $block->content ?? [];

        // Determine new content source
        if ($request->input('use_json') && !empty($validated['content_json'])) {
            $newContent = json_decode($validated['content_json'], true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->withErrors(['content_json' => 'Invalid JSON format.']);
            }
        } else {
            $newContent = $validated['content'] ?? [];

            // Handle Image Uploads (Only relevant if NOT using raw JSON override)
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $key => $file) {
                    $path = $file->store('uploads/blocks', 'public');
                    $newContent[$key] = '/storage/' . $path;
                }
            }

            // Merge with existing content to preserve keys not in form if any
            $newContent = array_merge($currentContent, $newContent);
        }

        $finalContent = $newContent;

        // Update other fields
        $block->type = $validated['type'];
        $block->identifier = $validated['identifier'];
        $block->order = $validated['order'];
        $block->content = $finalContent;
        $block->is_active = $request->has('is_active') ? ActiveStatus::ACTIVE : ActiveStatus::INACTIVE;

        $block->save();

        return redirect()->route('admin.pages.blocks.index', $block->page_id)->with('success', 'Block updated successfully.');
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus(ContentBlock $block)
    {
        $block->update([
            'is_active' => $block->is_active === ActiveStatus::ACTIVE ? ActiveStatus::INACTIVE : ActiveStatus::ACTIVE
        ]);

        return back()->with('success', 'Block status updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentBlock $block)
    {
        $pageId = $block->page_id;
        $block->delete();

        return redirect()->route('admin.pages.blocks.index', $pageId)->with('success', 'Block deleted successfully.');
    }
}
