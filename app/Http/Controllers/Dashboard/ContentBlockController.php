<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ContentBlock;
use App\Models\Page;
use Illuminate\Http\Request;

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
            'content' => 'nullable|json', // We expect a JSON string from the form
            'is_active' => 'boolean',
        ]);

        $validated['page_id'] = $page->id;
        $validated['is_active'] = $request->has('is_active');
        
        // Decode JSON content to array before saving, as model casts it
        if (!empty($validated['content'])) {
            $validated['content'] = json_decode($validated['content'], true);
        }

        ContentBlock::create($validated);

        return redirect()->route('admin.pages.blocks.index', $page->id)->with('success', 'Block added successfully.');
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
            'content' => 'nullable|json',
        ]);

        $validated['is_active'] = $request->has('is_active');

        if (!empty($validated['content'])) {
            $validated['content'] = json_decode($validated['content'], true);
        }

        $block->update($validated);

        return redirect()->route('admin.pages.blocks.index', $block->page_id)->with('success', 'Block updated successfully.');
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
