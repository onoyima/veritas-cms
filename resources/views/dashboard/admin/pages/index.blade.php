@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark">Website Pages</h1>
        <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-2"></i>Create New Page
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 border-bottom-0">Title / Slug</th>
                            <th class="px-4 py-3 border-bottom-0">Status</th>
                            <th class="px-4 py-3 border-bottom-0">Author</th>
                            <th class="px-4 py-3 border-bottom-0">Published</th>
                            <th class="px-4 py-3 border-bottom-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pages as $page)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="fw-semibold text-dark">{{ $page->title }}</div>
                                <div class="text-muted small">/{{ $page->slug }}</div>
                                @if($page->is_featured)
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill mt-1" style="font-size: 0.65rem;">
                                        <i class="fa-solid fa-star me-1"></i>Featured
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @php
                                    $statusClass = match($page->status) {
                                        'published' => 'success',
                                        'draft' => 'secondary',
                                        'pending' => 'warning',
                                        'archived' => 'dark',
                                        default => 'light'
                                    };
                                @endphp
                                <span class="badge bg-{{ $statusClass }}-subtle text-{{ $statusClass }} border border-{{ $statusClass }}-subtle rounded-pill text-capitalize">
                                    {{ $page->status }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-secondary-subtle d-flex align-items-center justify-content-center me-2" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                        {{ substr($page->creator->fname ?? 'S', 0, 1) }}{{ substr($page->creator->lname ?? 'A', 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="small fw-medium">{{ $page->creator->fname ?? 'System' }} {{ $page->creator->lname ?? 'Admin' }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">Created {{ $page->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-muted small">
                                @if($page->published_at)
                                    {{ $page->published_at->format('M d, Y') }}<br>
                                    <span class="text-xs">by {{ $page->approver->fname ?? 'System' }}</span>
                                @else
                                    <span class="text-muted fst-italic">Not published</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-end">
                                <div class="btn-group">
                                    @if($page->status === 'pending' && (auth()->guard('staff')->user()->hasWebsiteRole('super-admin') || auth()->guard('staff')->user()->role == 1))
                                    <form action="{{ route('admin.pages.update', $page->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="published">
                                        <button type="submit" class="btn btn-sm btn-success me-1" title="Approve & Publish">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    </form>
                                    @endif

                                    <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <a href="{{ route('admin.pages.blocks.index', $page->id) }}" class="btn btn-sm btn-outline-info" title="Manage Blocks">
                                        <i class="fa-solid fa-layer-group"></i>
                                    </a>
                                    
                                    <button type="button" class="btn btn-sm btn-outline-danger dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <form action="{{ route('admin.pages.toggle-status', $page->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="dropdown-item">
                                                    @if($page->status === \App\Enums\PageStatus::PUBLISHED)
                                                        <i class="fa-solid fa-eye-slash me-2"></i>Unpublish
                                                    @else
                                                        <i class="fa-solid fa-eye me-2"></i>Publish
                                                    @endif
                                                </button>
                                            </form>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this page?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fa-solid fa-trash me-2"></i>Delete
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <div class="mb-3">
                                    <i class="fa-regular fa-file-lines fa-3x text-secondary opacity-25"></i>
                                </div>
                                <h6 class="fw-bold">No pages found</h6>
                                <p class="small mb-3">Get started by creating your first page.</p>
                                <a href="{{ route('admin.pages.create') }}" class="btn btn-sm btn-primary">
                                    <i class="fa-solid fa-plus me-1"></i> Create Page
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($pages->hasPages())
        <div class="card-footer bg-white border-top-0 py-3">
            {{ $pages->links('pagination::bootstrap-5') }}
        </div>
        @endif
    </div>
</div>
@endsection
