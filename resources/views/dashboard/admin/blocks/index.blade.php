@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark">Content Blocks</h1>
            <p class="text-muted mb-0">Managing content for page: <strong>{{ $page->title }}</strong></p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left me-2"></i>Back to Pages
            </a>
            <a href="{{ route('admin.pages.blocks.create', $page->id) }}" class="btn btn-primary">
                <i class="fa-solid fa-plus me-2"></i>Add New Block
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="vstack gap-3">
        @forelse($blocks as $block)
        <div class="card border shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="badge bg-primary">{{ strtoupper($block->type) }}</span>
                            <h5 class="card-title mb-0">{{ $block->identifier ?? 'No Identifier' }}</h5>
                            @if($block->is_active === \App\Enums\ActiveStatus::INACTIVE)
                                <span class="badge bg-danger">Inactive</span>
                            @else
                                <span class="badge bg-success">Active</span>
                            @endif
                        </div>
                        <div class="text-muted small font-monospace bg-light p-2 rounded border d-inline-block">
                            Order: {{ $block->order }}
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <form action="{{ route('admin.blocks.toggle-status', $block->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm {{ $block->is_active === \App\Enums\ActiveStatus::ACTIVE ? 'btn-outline-warning' : 'btn-outline-success' }}" title="{{ $block->is_active === \App\Enums\ActiveStatus::ACTIVE ? 'Deactivate' : 'Activate' }}">
                                <i class="fa-solid {{ $block->is_active === \App\Enums\ActiveStatus::ACTIVE ? 'fa-eye-slash' : 'fa-eye' }}"></i>
                            </button>
                        </form>
                        <a href="{{ route('admin.blocks.edit', $block->id) }}" class="btn btn-sm btn-outline-primary">
                            <i class="fa-solid fa-pen"></i> Edit
                        </a>
                        <form action="{{ route('admin.blocks.destroy', $block->id) }}" method="POST" onsubmit="return confirm('Delete this block?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fa-solid fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>

                <div class="mt-3 pt-3 border-top">
                    <details>
                        <summary class="text-muted small cursor-pointer">View Content Preview</summary>
                        <pre class="mt-2 small bg-dark text-success p-3 rounded mb-0" style="max-height: 200px; overflow-y: auto;">{{ json_encode($block->content, JSON_PRETTY_PRINT) }}</pre>
                    </details>
                </div>
            </div>
        </div>
        @empty
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <p class="text-muted lead mb-3">No content blocks found for this page.</p>
                <a href="{{ route('admin.pages.blocks.create', $page->id) }}" class="btn btn-primary">Create your first block</a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection

