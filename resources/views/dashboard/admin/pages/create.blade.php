@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark">Create New Page</h1>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="card border-0 shadow-sm" style="max-width: 800px;">
        <div class="card-body p-4">
            <form action="{{ route('admin.pages.store') }}" method="POST">
                @csrf
                
                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold">Page Title</label>
                    <input type="text" name="title" id="title" class="form-control" required value="{{ old('title') }}">
                    @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label fw-semibold">Slug (Optional)</label>
                    <input type="text" name="slug" id="slug" class="form-control" placeholder="auto-generated-if-empty" value="{{ old('slug') }}">
                    @error('slug') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="meta_title" class="form-label fw-semibold">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title') }}">
                </div>

                <div class="mb-3">
                    <label for="meta_description" class="form-label fw-semibold">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" rows="3" class="form-control">{{ old('meta_description') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="status" class="form-label fw-semibold">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">Select Status</option>
                            @foreach(App\Enums\PageStatus::options() as $value => $label)
                                @if($value === 'published' && !(auth()->guard('staff')->user()->hasWebsiteRole('super-admin') || auth()->guard('staff')->user()->role == 1))
                                    @continue
                                @endif
                                <option value="{{ $value }}" {{ old('status') == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="is_active" class="form-label fw-semibold">Active</label>
                        <select name="is_active" id="is_active" class="form-select">
                            <option value="">Select</option>
                            @foreach(App\Enums\ActiveStatus::options() as $value => $label)
                                <option value="{{ $value }}" {{ old('is_active', App\Enums\ActiveStatus::ACTIVE->value) == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="is_featured" class="form-label fw-semibold">Featured</label>
                        <select name="is_featured" id="is_featured" class="form-select">
                            <option value="">Select</option>
                            @foreach(App\Enums\FeatureStatus::options() as $value => $label)
                                <option value="{{ $value }}" {{ old('is_featured', App\Enums\FeatureStatus::STANDARD->value) == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fa-solid fa-save me-2"></i>Create Page
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
