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
            <form action="{{ route('admin.blocks.update', $block->id) }}" method="POST" enctype="multipart/form-data">
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

                <hr class="my-4">

                <h5 class="fw-bold mb-3">Block Content</h5>
                <div id="content-fields">
                    @php
                        $content = $block->content ?? [];
                        if (is_string($content)) {
                            $content = json_decode($content, true) ?? [];
                        }
                    @endphp

                    @forelse($content as $key => $value)
                        @if(!Str::endsWith($key, ['_alt', '_caption']))
                        <div class="mb-3 p-3 border rounded bg-light">
                            <label class="form-label fw-bold text-capitalize">{{ str_replace('_', ' ', $key) }} <small class="text-muted fw-normal">({{ $key }})</small></label>

                            @if(Str::contains(strtolower($key), ['image', 'img', 'photo', 'banner', 'logo']))
                                {{-- Image Field --}}
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <input type="file" name="images[{{ $key }}]" class="form-control mb-2">
                                        <input type="hidden" name="content[{{ $key }}]" value="{{ $value }}">

                                        {{-- Alt Text and Caption --}}
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label class="form-label small text-muted">Alt Text</label>
                                                <input type="text" name="content[{{ $key }}_alt]" value="{{ $content[$key . '_alt'] ?? '' }}" class="form-control form-control-sm" placeholder="Describe image for accessibility">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small text-muted">Caption</label>
                                                <input type="text" name="content[{{ $key }}_caption]" value="{{ $content[$key . '_caption'] ?? '' }}" class="form-control form-control-sm" placeholder="Image caption">
                                            </div>
                                        </div>

                                        <small class="text-muted d-block mt-2">Upload to replace current image.</small>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        @if($value)
                                            <img src="{{ $value }}" alt="{{ $content[$key . '_alt'] ?? $key }}" class="img-fluid rounded border" style="max-height: 100px;">
                                            <div class="small text-muted mt-1 text-truncate">{{ $value }}</div>
                                        @else
                                            <span class="text-muted fst-italic">No image set</span>
                                        @endif
                                    </div>
                                </div>
                            @elseif(is_array($value))
                                {{-- Nested Array - Show as JSON for now --}}
                                <textarea name="content[{{ $key }}]" class="form-control font-monospace" rows="3">{{ json_encode($value) }}</textarea>
                                <small class="text-muted">Complex structure (JSON)</small>
                            @elseif(Str::length($value) > 100 || Str::contains(strtolower($key), ['desc', 'content', 'overview', 'text']))
                                {{-- Long Text --}}
                                <textarea name="content[{{ $key }}]" class="form-control" rows="4">{{ $value }}</textarea>
                            @else
                                {{-- Short Text --}}
                                <input type="text" name="content[{{ $key }}]" value="{{ $value }}" class="form-control">
                            @endif
                        </div>
                        @endif
                    @empty
                        <div class="alert alert-info">
                            No content fields defined. Add generic content below or switch to JSON mode.
                        </div>
                    @endforelse
                </div>

                <div class="mb-4 mt-3">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse" data-bs-target="#rawJsonCollapse">
                        <i class="fa-solid fa-code me-1"></i> Toggle Raw JSON Editor (Advanced)
                    </button>
                    <div class="collapse mt-3" id="rawJsonCollapse">
                        <div class="card card-body bg-light">
                            <label for="content_json" class="form-label fw-bold">Raw JSON Content</label>
                            <p class="text-muted small mb-2">Use this to add new fields or edit complex structures.</p>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="use_json" id="use_json" value="1">
                                <label class="form-check-label" for="use_json">
                                    <strong>Overwrite</strong> block content with this JSON
                                </label>
                            </div>
                            <textarea name="content_json" id="content_json" rows="10" class="form-control font-monospace">{{ json_encode($content, JSON_PRETTY_PRINT) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" {{ old('is_active', $block->is_active?->value ?? $block->is_active) ? 'checked' : '' }}>
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
