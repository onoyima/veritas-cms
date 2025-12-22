@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark">Edit Mass Schedule</h1>
        <a href="{{ route('admin.mass-schedules.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.mass-schedules.update', $mass_schedule->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4 mb-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="day" class="form-label fw-bold">Day <span class="text-danger">*</span></label>
                            <select name="day" id="day" class="form-select @error('day') is-invalid @enderror" required>
                                <option value="">-- Select Day --</option>
                                <option value="Sunday" {{ old('day', $mass_schedule->day) == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                                <option value="Monday" {{ old('day', $mass_schedule->day) == 'Monday' ? 'selected' : '' }}>Monday</option>
                                <option value="Tuesday" {{ old('day', $mass_schedule->day) == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                                <option value="Wednesday" {{ old('day', $mass_schedule->day) == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                                <option value="Thursday" {{ old('day', $mass_schedule->day) == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                                <option value="Friday" {{ old('day', $mass_schedule->day) == 'Friday' ? 'selected' : '' }}>Friday</option>
                                <option value="Saturday" {{ old('day', $mass_schedule->day) == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                                <option value="Daily" {{ old('day', $mass_schedule->day) == 'Daily' ? 'selected' : '' }}>Daily</option>
                            </select>
                            @error('day') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_time" class="form-label fw-bold">Start Time <span class="text-danger">*</span></label>
                                <input type="time" name="start_time" id="start_time" class="form-control @error('start_time') is-invalid @enderror" value="{{ old('start_time', \Carbon\Carbon::parse($mass_schedule->start_time)->format('H:i')) }}" required>
                                @error('start_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="end_time" class="form-label fw-bold">End Time <span class="text-danger">*</span></label>
                                <input type="time" name="end_time" id="end_time" class="form-control @error('end_time') is-invalid @enderror" value="{{ old('end_time', \Carbon\Carbon::parse($mass_schedule->end_time)->format('H:i')) }}" required>
                                @error('end_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="invitees" class="form-label fw-bold">Invitees / Groups</label>
                            <textarea name="invitees" id="invitees" rows="3" class="form-control @error('invitees') is-invalid @enderror" placeholder="e.g. Students, Staff, General Public">{{ old('invitees', $inviteesString) }}</textarea>
                            <div class="form-text">Separate multiple groups with commas.</div>
                            @error('invitees') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Status</h6>
                                <div class="mb-3">
                                    <select name="is_active" id="status" class="form-select">
                                        <option value="active" {{ old('is_active', $mass_schedule->is_active->value ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('is_active', $mass_schedule->is_active->value ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-4">
                    <a href="{{ route('admin.mass-schedules.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">Update Schedule</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
