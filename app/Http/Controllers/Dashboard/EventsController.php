<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\WebsiteEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Enums\ActiveStatus;
use Illuminate\Validation\Rules\Enum;
use Carbon\Carbon;

class EventsController extends Controller
{
    public function index()
    {
        $events = WebsiteEvent::orderBy('start_date_and_time', 'desc')->paginate(10);
        return view('dashboard.admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('dashboard.admin.events.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'heading' => 'required|string|max:255',
            'subheading' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:website_events,slug',
            'location' => 'nullable|string|max:255',
            'event_type' => 'nullable|string|max:100',
            'start_date_and_time' => 'nullable|date',
            'end_date_and_time' => 'nullable|date|after_or_equal:start_date_and_time',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|string',
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['heading']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/events', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        $validated['is_active'] = $validated['is_active'] ?? ActiveStatus::ACTIVE->value;

        WebsiteEvent::create($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully.');
    }

    public function edit(WebsiteEvent $event)
    {
        return view('dashboard.admin.events.edit', compact('event'));
    }

    public function update(Request $request, WebsiteEvent $event)
    {
        $validated = $request->validate([
            'heading' => 'required|string|max:255',
            'subheading' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:website_events,slug,' . $event->id,
            'location' => 'nullable|string|max:255',
            'event_type' => 'nullable|string|max:100',
            'start_date_and_time' => 'nullable|date',
            'end_date_and_time' => 'nullable|date|after_or_equal:start_date_and_time',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|string',
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['heading']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/events', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        $validated['is_active'] = $validated['is_active'] ?? ActiveStatus::INACTIVE->value;

        $event->update($validated);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully.');
    }

    public function destroy(WebsiteEvent $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event deleted successfully.');
    }
}
