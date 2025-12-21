@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark">Create News Article</h1>
        <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Back to News
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4 mb-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="heading" class="form-label fw-bold">Heading <span class="text-danger">*</span></label>
                            <input type="text" name="heading" id="heading" class="form-control @error('heading') is-invalid @enderror" value="{{ old('heading') }}" required>
                            @error('heading') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subheading" class="form-label fw-bold">Subheading</label>
                            <input type="text" name="subheading" id="subheading" class="form-control @error('subheading') is-invalid @enderror" value="{{ old('subheading') }}">
                            @error('subheading') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="overview" class="form-label fw-bold">Overview</label>
                            <textarea name="overview" id="overview" rows="3" class="form-control @error('overview') is-invalid @enderror">{{ old('overview') }}</textarea>
                            <div class="form-text">Brief introduction or summary.</div>
                            @error('overview') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label fw-bold">Main Content</label>
                            <textarea name="content" id="content" rows="10" class="form-control @error('content') is-invalid @enderror">{{ old('content') }}</textarea>
                            <div class="form-text">Main body of the article. Separate paragraphs with new lines.</div>
                            @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Publishing Options</h6>
                                
                                <div class="mb-3">
                                    <label for="status" class="form-label small text-muted">Status</label>
                                    <select name="is_active" id="status" class="form-select">
                                        <option value="active" {{ old('is_active') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('is_active') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="published_at" class="form-label small text-muted">Publish Date</label>
                                    <input type="date" name="published_at" id="published_at" class="form-control" value="{{ old('published_at', date('Y-m-d')) }}">
                                </div>

                                <div class="mb-3">
                                    <label for="author" class="form-label small text-muted">Author</label>
                                    <input type="text" name="author" id="author" class="form-control" value="{{ old('author') }}">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="slug" class="form-label small text-muted">Slug (Optional)</label>
                                    <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" placeholder="Auto-generated if empty">
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Featured Image</h6>
                                <input type="file" name="image" id="image" class="form-control mb-2" accept="image/*">
                                <div class="form-text small">Recommended size: 1200x630px</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-4">
                    <a href="{{ route('admin.news.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">Create Article</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
