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
            'files' => 'nullable|array', // Allow nested files
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

            // Attempt to decode JSON strings within the content array (fix for nested array editing)
            foreach ($newContent as $key => $value) {
                if (is_string($value) && (str_starts_with(trim($value), '[') || str_starts_with(trim($value), '{'))) {
                    $decoded = json_decode($value, true);
                    if (json_last_error() === JSON_ERROR_NONE) {
                        $newContent[$key] = $decoded;
                    }
                }
            }

            // Handle Image Uploads (Only relevant if NOT using raw JSON override)
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $key => $file) {
                    $path = $file->store('uploads/blocks', 'public');
                    $newContent[$key] = '/storage/' . $path;
                }
            }

            // Handle Nested File Uploads
            if ($request->hasFile('files')) {
                $newContent = $this->handleNestedUploads($newContent, $request->file('files'));
            }

            // Merge with existing content to preserve keys not in form if any
            $newContent = array_merge($currentContent, $newContent);
        }

        $finalContent = $newContent;

        try {
            // Update other fields
            $block->type = $validated['type'];
            $block->identifier = $validated['identifier'];
            $block->order = $validated['order'];
            $block->content = $finalContent;
            $block->is_active = $request->has('is_active') ? ActiveStatus::ACTIVE : ActiveStatus::INACTIVE;

            $block->save();
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update block: ' . $e->getMessage());
        }

        return redirect()->route('admin.pages.blocks.index', $block->page_id)->with('success', 'Block updated successfully.');
    }

    /**
     * Toggle the status of the specified resource.
     */
    public function toggleStatus(ContentBlock $block)
    {
        try {
            $block->update([
                'is_active' => $block->is_active === ActiveStatus::ACTIVE ? ActiveStatus::INACTIVE : ActiveStatus::ACTIVE
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to toggle status: ' . $e->getMessage());
        }

        return back()->with('success', 'Block status updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContentBlock $block)
    {
        $pageId = $block->page_id;
        try {
            $block->delete();
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete block: ' . $e->getMessage());
        }

        return redirect()->route('admin.pages.blocks.index', $pageId)->with('success', 'Block deleted successfully.');
    }

    /**
     * Handle nested file uploads recursively.
     *
     * @param array $content Current content array
     * @param array $files Files array structure matching content
     * @return array Updated content array with file URLs
     */
    private function handleNestedUploads(array $content, array $files): array
    {
        foreach ($files as $key => $value) {
            if (is_array($value)) {
                // Ensure the corresponding content key exists and is an array to traverse
                // If it doesn't exist (e.g. new item), initialize it.
                // However, for repeater items, the text inputs should have already populated $content structure via $request->input('content').
                // But if the file input is the ONLY input for a key, $content[$key] might not exist yet if we relied on merging.
                // Since we merge $validated['content'] (text inputs) BEFORE calling this, $content should have the structure.
                
                if (!isset($content[$key])) {
                    $content[$key] = []; 
                }
                
                // Recurse
                // If $content[$key] is not an array (e.g. it was a string value), force it to array?
                // No, structure should match.
                if (is_array($content[$key])) {
                    $content[$key] = $this->handleNestedUploads($content[$key], $value);
                }
            } elseif ($value instanceof \Illuminate\Http\UploadedFile) {
                // Upload file
                $path = $value->store('uploads/blocks', 'public');
                $content[$key] = '/storage/' . $path;
            }
        }
        return $content;
    }
}
