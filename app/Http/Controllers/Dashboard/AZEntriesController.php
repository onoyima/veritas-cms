<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\WebsiteAZEntry;
use Illuminate\Http\Request;
use App\Enums\ActiveStatus;
use Illuminate\Validation\Rules\Enum;

class AZEntriesController extends Controller
{
    public function index()
    {
        $entries = WebsiteAZEntry::orderBy('alphabet', 'asc')->orderBy('topic', 'asc')->paginate(20);
        return view('dashboard.admin.az-entries.index', compact('entries'));
    }

    public function create()
    {
        return view('dashboard.admin.az-entries.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'topic' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
        ]);

        // Auto-determine alphabet from topic
        $validated['alphabet'] = strtoupper(substr($validated['topic'], 0, 1));
        $validated['is_active'] = $validated['is_active'] ?? ActiveStatus::ACTIVE->value;

        WebsiteAZEntry::create($validated);

        return redirect()->route('admin.az-entries.index')->with('success', 'Entry created successfully.');
    }

    public function edit(WebsiteAZEntry $entry)
    {
        return view('dashboard.admin.az-entries.edit', compact('entry'));
    }

    public function update(Request $request, WebsiteAZEntry $entry)
    {
        $validated = $request->validate([
            'topic' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
        ]);

        $validated['alphabet'] = strtoupper(substr($validated['topic'], 0, 1));
        $validated['is_active'] = $validated['is_active'] ?? ActiveStatus::INACTIVE->value;

        $entry->update($validated);

        return redirect()->route('admin.az-entries.index')->with('success', 'Entry updated successfully.');
    }

    public function destroy(WebsiteAZEntry $entry)
    {
        $entry->delete();
        return redirect()->route('admin.az-entries.index')->with('success', 'Entry deleted successfully.');
    }
}
