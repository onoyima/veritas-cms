@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark">Add Publication</h1>
        <a href="{{ route('admin.publications.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.publications.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4 mb-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="title1" class="form-label fw-bold">Title / Main Heading <span class="text-danger">*</span></label>
                            <input type="text" name="title1" id="title1" class="form-control @error('title1') is-invalid @enderror" value="{{ old('title1') }}" required>
                            @error('title1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title2" class="form-label fw-bold">Subtitle / Author(s)</label>
                            <input type="text" name="title2" id="title2" class="form-control @error('title2') is-invalid @enderror" value="{{ old('title2') }}">
                            @error('title2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="additional_info" class="form-label fw-bold">Additional Info / Description</label>
                            <textarea name="additional_info" id="additional_info" rows="4" class="form-control @error('additional_info') is-invalid @enderror">{{ old('additional_info') }}</textarea>
                            @error('additional_info') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="publication_url" class="form-label fw-bold">Publication Link (URL)</label>
                            <input type="url" name="publication_url" id="publication_url" class="form-control @error('publication_url') is-invalid @enderror" value="{{ old('publication_url') }}" placeholder="https://">
                            @error('publication_url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Settings</h6>
                                
                                <div class="mb-3">
                                    <label for="category" class="form-label fw-bold">Category</label>
                                    <input type="text" name="category" id="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category') }}" placeholder="e.g. Journal, Book, Article">
                                    @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label fw-bold">Status</label>
                                    <select name="is_active" id="status" class="form-select">
                                        <option value="active" {{ old('is_active') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('is_active') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Cover Image</h6>
                                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                <div class="form-text small">Recommended size: 300x400px</div>
                                @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-4">
                    <a href="{{ route('admin.publications.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">Save Publication</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
