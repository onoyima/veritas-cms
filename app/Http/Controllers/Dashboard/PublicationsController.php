<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\WebsitePublication;
use Illuminate\Http\Request;
use App\Enums\ActiveStatus;
use Illuminate\Validation\Rules\Enum;

class PublicationsController extends Controller
{
    public function index()
    {
        $publications = WebsitePublication::orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.admin.publications.index', compact('publications'));
    }

    public function create()
    {
        return view('dashboard.admin.publications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title1' => 'required|string|max:255',
            'title2' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|string',
            'additional_info' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'publication_url' => 'nullable|url|max:255',
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/publications', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        $validated['is_active'] = $validated['is_active'] ?? ActiveStatus::ACTIVE->value;

        WebsitePublication::create($validated);

        return redirect()->route('admin.publications.index')->with('success', 'Publication created successfully.');
    }

    public function edit(WebsitePublication $publication)
    {
        return view('dashboard.admin.publications.edit', compact('publication'));
    }

    public function update(Request $request, WebsitePublication $publication)
    {
        $validated = $request->validate([
            'title1' => 'required|string|max:255',
            'title2' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|string',
            'additional_info' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'publication_url' => 'nullable|url|max:255',
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/publications', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        $validated['is_active'] = $validated['is_active'] ?? ActiveStatus::INACTIVE->value;

        $publication->update($validated);

        return redirect()->route('admin.publications.index')->with('success', 'Publication updated successfully.');
    }

    public function destroy(WebsitePublication $publication)
    {
        $publication->delete();
        return redirect()->route('admin.publications.index')->with('success', 'Publication deleted successfully.');
    }
}
