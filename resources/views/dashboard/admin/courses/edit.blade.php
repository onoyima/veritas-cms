@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark">Edit Course</h1>
        <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.courses.update', $course->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4 mb-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="course_name" class="form-label fw-bold">Course Name <span class="text-danger">*</span></label>
                            <input type="text" name="course_name" id="course_name" class="form-control @error('course_name') is-invalid @enderror" value="{{ old('course_name', $course->course_name) }}" required>
                            @error('course_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label fw-bold">Slug</label>
                            <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug', $course->slug) }}">
                            @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="faculty" class="form-label fw-bold">Faculty</label>
                            <input type="text" name="faculty" id="faculty" class="form-control @error('faculty') is-invalid @enderror" value="{{ old('faculty', $course->faculty) }}">
                            @error('faculty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Status</h6>
                                <div class="mb-3">
                                    <select name="is_active" id="status" class="form-select">
                                        <option value="active" {{ old('is_active', $course->is_active->value ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('is_active', $course->is_active->value ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-4">
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">Update Course</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
