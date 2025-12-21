@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark">Add Content Block</h1>
        <a href="{{ route('admin.pages.blocks.index', $page->id) }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Back to Blocks
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.pages.blocks.store', $page->id) }}" method="POST">
                @csrf
                
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label for="type" class="form-label fw-bold">Block Type</label>
                        <select name="type" id="type" class="form-select">
                            <option value="hero">Hero Section</option>
                            <option value="text">Text / HTML</option>
                            <option value="features">Features Grid</option>
                            <option value="image_text">Image + Text</option>
                            <option value="cta">Call to Action</option>
                            <option value="custom">Custom JSON</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="identifier" class="form-label fw-bold">Identifier (Optional)</label>
                        <input type="text" name="identifier" id="identifier" class="form-control" placeholder="e.g., homepage-hero-1">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="order" class="form-label fw-bold">Sort Order</label>
                    <input type="number" name="order" id="order" class="form-control" value="0">
                </div>

                <div class="mb-4">
                    <label for="content" class="form-label fw-bold">Content (JSON)</label>
                    <p class="text-muted small mb-2">Enter valid JSON structure for the block content.</p>
                    <textarea name="content" id="content" rows="10" class="form-control font-monospace">{}</textarea>
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" checked>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save me-2"></i>Save Block
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

