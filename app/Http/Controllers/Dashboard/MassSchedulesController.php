<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\WebsiteMassSchedule;
use Illuminate\Http\Request;
use App\Enums\ActiveStatus;
use Illuminate\Validation\Rules\Enum;

class MassSchedulesController extends Controller
{
    public function index()
    {
        $schedules = WebsiteMassSchedule::orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.admin.mass-schedules.index', compact('schedules'));
    }

    public function create()
    {
        return view('dashboard.admin.mass-schedules.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'day' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'invitees' => 'nullable|string',
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
        ]);

        // Process invitees from comma-separated string to array
        if (!empty($validated['invitees'])) {
            $validated['invitees'] = array_map('trim', explode(',', $validated['invitees']));
        } else {
            $validated['invitees'] = [];
        }

        $validated['is_active'] = $validated['is_active'] ?? ActiveStatus::ACTIVE->value;

        WebsiteMassSchedule::create($validated);

        return redirect()->route('admin.mass-schedules.index')->with('success', 'Schedule created successfully.');
    }

    public function edit(WebsiteMassSchedule $mass_schedule)
    {
        // Convert array back to comma-separated string for editing
        $inviteesString = is_array($mass_schedule->invitees) ? implode(', ', $mass_schedule->invitees) : '';
        return view('dashboard.admin.mass-schedules.edit', compact('mass_schedule', 'inviteesString'));
    }

    public function update(Request $request, WebsiteMassSchedule $mass_schedule)
    {
        $validated = $request->validate([
            'day' => 'required|string|max:255',
            'start_time' => 'required|date_format:H:i', // Format H:i for time inputs
            'end_time' => 'required|date_format:H:i|after:start_time',
            'invitees' => 'nullable|string',
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
        ]);

        if (!empty($validated['invitees'])) {
            $validated['invitees'] = array_map('trim', explode(',', $validated['invitees']));
        } else {
            $validated['invitees'] = [];
        }

        $validated['is_active'] = $validated['is_active'] ?? ActiveStatus::INACTIVE->value;

        $mass_schedule->update($validated);

        return redirect()->route('admin.mass-schedules.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy(WebsiteMassSchedule $mass_schedule)
    {
        $mass_schedule->delete();
        return redirect()->route('admin.mass-schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}
