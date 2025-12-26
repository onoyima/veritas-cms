@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark">Edit Page: {{ $page->title }}</h1>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="card border-0 shadow-sm" style="max-width: 800px;">
        <div class="card-body p-4">
            <form action="{{ route('admin.pages.update', $page->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="title" class="form-label fw-semibold">Page Title</label>
                    <input type="text" name="title" id="title" class="form-control" required value="{{ old('title', $page->title) }}">
                    @error('title') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label fw-semibold">Slug</label>
                    <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $page->slug) }}">
                    @error('slug') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <div class="mb-3">
                    <label for="meta_title" class="form-label fw-semibold">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title', $page->meta_title) }}">
                </div>

                <div class="mb-3">
                    <label for="meta_description" class="form-label fw-semibold">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" rows="3" class="form-control">{{ old('meta_description', $page->meta_description) }}</textarea>
                </div>

                <hr class="my-4">
                <div class="mb-3">
                    <label for="content" class="form-label fw-semibold">Intro Content</label>
                    @php
                        $content = $page->content ?? [];
                        if (is_string($content)) { $content = json_decode($content, true) ?? []; }
                        // Extract plain text from rich-text for easy editing
                        $contentText = '';
                        if (is_array($content) && isset($content['content'])) {
                            foreach ($content['content'] as $node) {
                                if (($node['nodeType'] ?? '') === 'paragraph') {
                                    foreach ($node['content'] ?? [] as $inner) {
                                        if (($inner['nodeType'] ?? '') === 'text') {
                                            $contentText .= ($inner['value'] ?? '') . "\n\n";
                                        }
                                    }
                                }
                            }
                            $contentText = trim($contentText);
                        }
                    @endphp
                    <textarea name="content" id="content" rows="5" class="form-control" placeholder="Write the page introduction. Use new lines to separate paragraphs.">{{ old('content', $contentText) }}</textarea>
                    <small class="text-muted">This becomes the page intro on the frontend. It supports paragraphs.</small>
                </div>
                <div class="mb-3">
                    <label for="image_url" class="form-label fw-semibold">Hero Image URL</label>
                    <input type="text" name="image_url" id="image_url" class="form-control" value="{{ old('image_url', $page->image_url) }}" placeholder="https://...">
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                        <div class="col-md-6 text-center">
                            @if($page->image_url)
                                <img src="{{ $page->image_url }}" alt="Current Image" class="img-fluid rounded border" style="max-height: 120px;">
                                <div class="small text-muted mt-1 text-truncate">{{ $page->image_url }}</div>
                            @else
                                <span class="text-muted fst-italic">No hero image set</span>
                            @endif
                        </div>
                    </div>
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
                                <option value="{{ $value }}" {{ old('status', $page->status?->value) == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('status') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="is_active" class="form-label fw-semibold">Active</label>
                        <select name="is_active" id="is_active" class="form-select">
                            <option value="">Select</option>
                            @foreach(App\Enums\ActiveStatus::options() as $value => $label)
                                <option value="{{ $value }}" {{ old('is_active', $page->is_active?->value) == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="is_featured" class="form-label fw-semibold">Featured</label>
                        <select name="is_featured" id="is_featured" class="form-select">
                            <option value="">Select</option>
                            @foreach(App\Enums\FeatureStatus::options() as $value => $label)
                                <option value="{{ $value }}" {{ old('is_featured', $page->is_featured?->value) == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fa-solid fa-save me-2"></i>Update Page
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
