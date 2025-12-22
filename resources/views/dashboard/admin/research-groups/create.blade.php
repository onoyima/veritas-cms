@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark">Add Research Group</h1>
        <a href="{{ route('admin.research-groups.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.research-groups.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">
                    <!-- Left Column -->
                    <div class="col-md-8">
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Basic Information</h6>
                                <div class="mb-3">
                                    <label for="title" class="form-label fw-bold">Group Title <span class="text-danger">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                                    @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="slug" class="form-label fw-bold">Slug (Optional)</label>
                                    <input type="text" name="slug" id="slug" class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}" placeholder="Auto-generated if left blank">
                                    @error('slug') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Spotlight Section -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">Spotlight Feature</h5>
                            
                            <div class="mb-3">
                                <label for="spotlight" class="form-label fw-bold">Spotlight Description</label>
                                <textarea name="spotlight" id="spotlight" rows="4" class="form-control @error('spotlight') is-invalid @enderror">{{ old('spotlight') }}</textarea>
                                @error('spotlight') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="spotlight_url" class="form-label fw-bold">Spotlight Link</label>
                                    <input type="url" name="spotlight_url" id="spotlight_url" class="form-control @error('spotlight_url') is-invalid @enderror" value="{{ old('spotlight_url') }}">
                                    @error('spotlight_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="spotlight_image_file" class="form-label fw-bold">Spotlight Image</label>
                                    <input type="file" name="spotlight_image_file" id="spotlight_image_file" class="form-control @error('spotlight_image_file') is-invalid @enderror" accept="image/*">
                                    @error('spotlight_image_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Research Focus Areas -->
                        <div class="mb-4">
                            <h5 class="border-bottom pb-2 mb-3">Research Focus Areas</h5>
                            
                            <div class="card mb-3 border">
                                <div class="card-header bg-white fw-bold">Focus Area 1</div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold">Title</label>
                                        <input type="text" name="research_focus_title1" class="form-control" value="{{ old('research_focus_title1') }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold">Content</label>
                                        <textarea name="research_focus_content1" rows="3" class="form-control">{{ old('research_focus_content1') }}</textarea>
                                    </div>
                                    <div>
                                        <label class="form-label small fw-bold">Image</label>
                                        <input type="file" name="research_focus_image1" class="form-control" accept="image/*">
                                    </div>
                                </div>
                            </div>

                            <div class="card mb-3 border">
                                <div class="card-header bg-white fw-bold">Focus Area 2</div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold">Title</label>
                                        <input type="text" name="research_focus_title2" class="form-control" value="{{ old('research_focus_title2') }}">
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small fw-bold">Content</label>
                                        <textarea name="research_focus_content2" rows="3" class="form-control">{{ old('research_focus_content2') }}</textarea>
                                    </div>
                                    <div>
                                        <label class="form-label small fw-bold">Image</label>
                                        <input type="file" name="research_focus_image2" class="form-control" accept="image/*">
                                    </div>
                                </div>
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
                                        <option value="active" {{ old('is_active') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('is_active') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Group Image</h6>
                                <input type="file" name="image" id="image" class="form-control mb-2 @error('image') is-invalid @enderror" accept="image/*">
                                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Researchers</h6>
                                <div class="overflow-auto" style="max-height: 200px;">
                                    @foreach($personnel as $person)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="personnel_ids[]" value="{{ $person->id }}" id="person_{{ $person->id }}" 
                                                {{ in_array($person->id, old('personnel_ids', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="person_{{ $person->id }}">
                                                {{ $person->first_name }} {{ $person->last_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Publications</h6>
                                <div class="overflow-auto" style="max-height: 200px;">
                                    @foreach($publications as $pub)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="publication_ids[]" value="{{ $pub->id }}" id="pub_{{ $pub->id }}"
                                                {{ in_array($pub->id, old('publication_ids', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="pub_{{ $pub->id }}">
                                                {{ $pub->title1 }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-4">
                    <a href="{{ route('admin.research-groups.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">Save Research Group</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
