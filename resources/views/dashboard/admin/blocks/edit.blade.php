@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark">Edit Block</h1>
        <a href="{{ route('admin.pages.blocks.index', $block->page_id) }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Back to Blocks
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.blocks.update', $block->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label for="type" class="form-label fw-bold">Block Type</label>
                        <input type="text" name="type" id="type" value="{{ old('type', $block->type) }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label for="identifier" class="form-label fw-bold">Identifier (Optional)</label>
                        <input type="text" name="identifier" id="identifier" value="{{ old('identifier', $block->identifier) }}" class="form-control">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="order" class="form-label fw-bold">Sort Order</label>
                    <input type="number" name="order" id="order" value="{{ old('order', $block->order) }}" class="form-control">
                </div>

                <div class="mb-4">
                    <label for="content" class="form-label fw-bold">Content (JSON)</label>
                    <p class="text-muted small mb-2">Enter valid JSON structure for the block content.</p>
                    <textarea name="content" id="content" rows="15" class="form-control font-monospace">{{ old('content', json_encode($block->content, JSON_PRETTY_PRINT)) }}</textarea>
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" {{ old('is_active', $block->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save me-2"></i>Update Block
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

