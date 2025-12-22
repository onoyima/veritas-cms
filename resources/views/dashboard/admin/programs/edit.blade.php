@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark">Edit Program</h1>
        <a href="{{ route('admin.programs.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.programs.update', $program->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <!-- Left Column -->
                    <div class="col-md-8">
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Basic Information</h6>
                                <div class="mb-3">
                                    <label for="course_id" class="form-label fw-bold">Select Course</label>
                                    <select name="course_id" id="course_id" class="form-select @error('course_id') is-invalid @enderror">
                                        <option value="">-- Select Course (Optional) --</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" {{ old('course_id', $program->course_id) == $course->id ? 'selected' : '' }}>
                                                {{ $course->course_name }} ({{ $course->faculty ?? 'No Faculty' }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('course_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="program_category" class="form-label fw-bold">Category</label>
                                        <select name="program_category" id="program_category" class="form-select @error('program_category') is-invalid @enderror">
                                            <option value="undergraduate" {{ old('program_category', $program->program_category) == 'undergraduate' ? 'selected' : '' }}>Undergraduate</option>
                                            <option value="postgraduate" {{ old('program_category', $program->program_category) == 'postgraduate' ? 'selected' : '' }}>Postgraduate</option>
                                            <option value="short-course" {{ old('program_category', $program->program_category) == 'short-course' ? 'selected' : '' }}>Short Course</option>
                                        </select>
                                        @error('program_category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="program_level" class="form-label fw-bold">Level</label>
                                        <input type="text" name="program_level" id="program_level" class="form-control @error('program_level') is-invalid @enderror" value="{{ old('program_level', $program->program_level) }}" placeholder="e.g. 100-400">
                                        @error('program_level') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="degree" class="form-label fw-bold">Degree Awarded</label>
                                        <input type="text" name="degree" id="degree" class="form-control @error('degree') is-invalid @enderror" value="{{ old('degree', $program->degree) }}" placeholder="e.g. B.Sc, M.Sc">
                                        @error('degree') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="faculty" class="form-label fw-bold">Faculty</label>
                                        <input type="text" name="faculty" id="faculty" class="form-control @error('faculty') is-invalid @enderror" value="{{ old('faculty', $program->faculty) }}">
                                        @error('faculty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="duration" class="form-label fw-bold">Duration (Years)</label>
                                        <input type="number" name="duration" id="duration" class="form-control @error('duration') is-invalid @enderror" value="{{ old('duration', $program->duration) }}" min="1">
                                        @error('duration') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="accredited_students" class="form-label fw-bold">Accredited Students Capacity</label>
                                        <input type="number" name="accredited_students" id="accredited_students" class="form-control @error('accredited_students') is-invalid @enderror" value="{{ old('accredited_students', $program->accredited_students) }}" min="0">
                                        @error('accredited_students') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Content Sections -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">Program Details</h5>
                            
                            <div class="mb-3">
                                <label for="program_description" class="form-label fw-bold">Program Description</label>
                                <textarea name="program_description" id="program_description" rows="5" class="form-control">{{ old('program_description', $program->program_description_text) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="eligibility_criteria" class="form-label fw-bold">Eligibility Criteria</label>
                                <textarea name="eligibility_criteria" id="eligibility_criteria" rows="5" class="form-control">{{ old('eligibility_criteria', $program->eligibility_criteria_text) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="how_to_apply" class="form-label fw-bold">How to Apply</label>
                                <textarea name="how_to_apply" id="how_to_apply" rows="5" class="form-control">{{ old('how_to_apply', $program->how_to_apply_text) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="financial_aid" class="form-label fw-bold">Financial Aid</label>
                                <textarea name="financial_aid" id="financial_aid" rows="5" class="form-control">{{ old('financial_aid', $program->financial_aid_text) }}</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label for="research_facilities" class="form-label fw-bold">Research Facilities</label>
                                <textarea name="research_facilities" id="research_facilities" rows="5" class="form-control">{{ old('research_facilities', $program->research_facilities_text) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label for="transfer_candidates" class="form-label fw-bold">Transfer Candidates Info</label>
                                <textarea name="transfer_candidates" id="transfer_candidates" rows="5" class="form-control">{{ old('transfer_candidates', $program->transfer_candidates_text) }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-4">
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Status</h6>
                                <div class="mb-3">
                                    <select name="is_active" id="status" class="form-select">
                                        <option value="active" {{ old('is_active', $program->is_active->value ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('is_active', $program->is_active->value ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="slug" class="form-label small text-muted">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $program->slug) }}">
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Program Image</h6>
                                @if($program->image_url)
                                    <div class="mb-3">
                                        <img src="{{ $program->image_url }}" alt="Program Image" class="img-fluid rounded border">
                                    </div>
                                @endif
                                <input type="file" name="image" id="image" class="form-control mb-2" accept="image/*">
                                <div class="form-text small">Upload to replace the existing image.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-4">
                    <a href="{{ route('admin.programs.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">Update Program</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
