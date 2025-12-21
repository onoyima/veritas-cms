@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark">Edit Student Group</h1>
        <a href="{{ route('admin.student-groups.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.student-groups.update', $studentGroup->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4 mb-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">Group Name <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $studentGroup->title) }}" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $studentGroup->description) }}</textarea>
                            <div class="form-text">Brief description of the student group.</div>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="member_count" class="form-label fw-bold">Member Count</label>
                            <input type="text" name="member_count" id="member_count" class="form-control @error('member_count') is-invalid @enderror" value="{{ old('member_count', $studentGroup->member_count) }}" placeholder="e.g. 50+">
                            @error('member_count') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Status</h6>
                                <div class="mb-3">
                                    <select name="is_active" id="status" class="form-select">
                                        <option value="active" {{ old('is_active', $studentGroup->is_active->value ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('is_active', $studentGroup->is_active->value ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="slug" class="form-label small text-muted">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $studentGroup->slug) }}">
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Group Image</h6>
                                
                                @if($studentGroup->image_url)
                                    <div class="mb-3 text-center">
                                        <img src="{{ $studentGroup->image_url }}" alt="Current Image" class="img-fluid rounded border" style="max-height: 200px;">
                                    </div>
                                @endif

                                <input type="file" name="image" id="image" class="form-control mb-2" accept="image/*">
                                <div class="form-text small">Upload to replace current image.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-4">
                    <a href="{{ route('admin.student-groups.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">Update Group</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
