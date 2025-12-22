@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark">Edit A-Z Entry</h1>
        <a href="{{ route('admin.az-entries.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.az-entries.update', $entry->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4 mb-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="topic" class="form-label fw-bold">Topic Name <span class="text-danger">*</span></label>
                            <input type="text" name="topic" id="topic" class="form-control @error('topic') is-invalid @enderror" value="{{ old('topic', $entry->topic) }}" required>
                            @error('topic') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="link" class="form-label fw-bold">Link URL</label>
                            <input type="text" name="link" id="link" class="form-control @error('link') is-invalid @enderror" value="{{ old('link', $entry->link) }}" placeholder="/about or https://example.com">
                            @error('link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $entry->description) }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Status</h6>
                                <div class="mb-3">
                                    <select name="is_active" id="status" class="form-select">
                                        <option value="active" {{ old('is_active', $entry->is_active->value ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('is_active', $entry->is_active->value ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                                
                                <div class="alert alert-info small mb-0">
                                    <i class="fa-solid fa-info-circle me-1"></i>
                                    The alphabet index (currently: <strong>{{ $entry->alphabet }}</strong>) will be automatically updated if the Topic Name changes.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-4">
                    <a href="{{ route('admin.az-entries.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">Update Entry</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
