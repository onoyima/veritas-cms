@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark">Edit Event</h1>
        <a href="{{ route('admin.events.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4 mb-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="heading" class="form-label fw-bold">Event Name <span class="text-danger">*</span></label>
                            <input type="text" name="heading" id="heading" class="form-control @error('heading') is-invalid @enderror" value="{{ old('heading', $event->heading) }}" required>
                            @error('heading') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subheading" class="form-label fw-bold">Subheading / Brief Description</label>
                            <textarea name="subheading" id="subheading" rows="3" class="form-control @error('subheading') is-invalid @enderror">{{ old('subheading', $event->subheading) }}</textarea>
                            @error('subheading') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="location" class="form-label fw-bold">Location</label>
                                <input type="text" name="location" id="location" class="form-control @error('location') is-invalid @enderror" value="{{ old('location', $event->location) }}" placeholder="e.g. Main Auditorium">
                                @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="event_type" class="form-label fw-bold">Event Type</label>
                                <input type="text" name="event_type" id="event_type" class="form-control @error('event_type') is-invalid @enderror" value="{{ old('event_type', $event->event_type) }}" placeholder="e.g. Social, Academic">
                                @error('event_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_date_and_time" class="form-label fw-bold">Start Date & Time</label>
                                <input type="datetime-local" name="start_date_and_time" id="start_date_and_time" class="form-control @error('start_date_and_time') is-invalid @enderror" value="{{ old('start_date_and_time', $event->start_date_and_time ? $event->start_date_and_time->format('Y-m-d\TH:i') : '') }}">
                                @error('start_date_and_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="end_date_and_time" class="form-label fw-bold">End Date & Time</label>
                                <input type="datetime-local" name="end_date_and_time" id="end_date_and_time" class="form-control @error('end_date_and_time') is-invalid @enderror" value="{{ old('end_date_and_time', $event->end_date_and_time ? $event->end_date_and_time->format('Y-m-d\TH:i') : '') }}">
                                @error('end_date_and_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Status</h6>
                                <div class="mb-3">
                                    <select name="is_active" id="status" class="form-select">
                                        <option value="active" {{ old('is_active', $event->is_active->value ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('is_active', $event->is_active->value ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="slug" class="form-label small text-muted">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $event->slug) }}">
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Event Image</h6>
                                
                                @if($event->image_url)
                                    <div class="mb-3 text-center">
                                        <img src="{{ $event->image_url }}" alt="Current Image" class="img-fluid rounded border" style="max-height: 200px;">
                                    </div>
                                @endif

                                <input type="file" name="image" id="image" class="form-control mb-2" accept="image/*">
                                <div class="form-text small">Upload to replace current image.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-4">
                    <a href="{{ route('admin.events.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">Update Event</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
