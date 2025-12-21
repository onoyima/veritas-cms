<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\WebsitePersonnel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Enums\ActiveStatus;
use Illuminate\Validation\Rules\Enum;
use App\Traits\HandlesRichText;

class PersonnelController extends Controller
{
    use HandlesRichText;

    public function index()
    {
        $personnel = WebsitePersonnel::orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.admin.personnel.index', compact('personnel'));
    }

    public function create()
    {
        return view('dashboard.admin.personnel.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:50',
            'position' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:website_personnel,slug',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'nullable|string|max:50',
            'whatsapp_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'biography' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|string',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/personnel', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        $validated['biography'] = $this->createRichText($validated['biography'] ?? '');
        $validated['is_active'] = $validated['is_active'] ?? ActiveStatus::ACTIVE->value;

        WebsitePersonnel::create($validated);

        return redirect()->route('admin.personnel.index')->with('success', 'Personnel created successfully.');
    }

    public function edit(WebsitePersonnel $personnel)
    {
        $personnel->biography_text = $this->extractTextFromRichText($personnel->biography);
        return view('dashboard.admin.personnel.edit', compact('personnel'));
    }

    public function update(Request $request, WebsitePersonnel $personnel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:50',
            'position' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:website_personnel,slug,' . $personnel->id,
            'email' => 'nullable|email|max:255',
            'phone_number' => 'nullable|string|max:50',
            'whatsapp_number' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'biography' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|string',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/personnel', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        $validated['biography'] = $this->createRichText($validated['biography'] ?? '');
        $validated['is_active'] = $validated['is_active'] ?? ActiveStatus::INACTIVE->value;

        $personnel->update($validated);

        return redirect()->route('admin.personnel.index')->with('success', 'Personnel updated successfully.');
    }

    public function destroy(WebsitePersonnel $personnel)
    {
        $personnel->delete();
        return redirect()->route('admin.personnel.index')->with('success', 'Personnel deleted successfully.');
    }
}
