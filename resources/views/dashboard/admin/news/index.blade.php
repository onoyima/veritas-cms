@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark">News & Articles</h1>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-2"></i>Create New Article
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
            <div class="px-4 pt-3 pb-2 border-bottom d-flex gap-2 justify-content-between align-items-center">
                <form method="GET" action="{{ route('admin.news.index') }}" class="d-flex align-items-center gap-2 w-100" role="search">
                    <div class="input-group input-group-sm w-auto">
                        <span class="input-group-text bg-white"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search articles...">
                    </div>
                    @if(request('search'))
                        <a href="{{ route('admin.news.index') }}" class="btn btn-sm btn-light">Clear</a>
                    @endif
                </form>
                <div class="text-muted small d-none d-md-block">
                    Showing {{ $news->firstItem() ?? 0 }}–{{ $news->lastItem() ?? 0 }} of {{ $news->total() }} results
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 border-bottom-0">Heading / Slug</th>
                            <th class="px-4 py-3 border-bottom-0">Status</th>
                            <th class="px-4 py-3 border-bottom-0">Author</th>
                            <th class="px-4 py-3 border-bottom-0">Published At</th>
                            <th class="px-4 py-3 border-bottom-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($news as $article)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    @if($article->image_url)
                                        <img src="{{ $article->image_url }}" alt="" class="rounded me-3" style="width: 48px; height: 48px; object-fit: cover;">
                                    @endif
                                    <div>
                                        <div class="fw-semibold text-dark">{{ Str::limit($article->heading, 50) }}</div>
                                        <div class="text-muted small">/{{ $article->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @if($article->is_active === \App\Enums\ActiveStatus::ACTIVE)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Active</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill">Inactive</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="small fw-medium">{{ $article->author ?? 'Unknown' }}</div>
                            </td>
                            <td class="px-4 py-3 text-muted small">
                                @if($article->published_at)
                                    {{ $article->published_at->format('M d, Y') }}
                                @else
                                    <span class="text-muted fst-italic">Draft</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-end">
                                <div class="btn-group">
                                    <a href="{{ route('admin.news.edit', $article->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.news.destroy', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-5 text-center text-muted">
                                <i class="fa-regular fa-newspaper fa-2x mb-3 d-block"></i>
                                No news articles found. Create one to get started.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($news->hasPages())
            <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Page {{ $news->currentPage() }} of {{ $news->lastPage() }}
                </div>
                {{ $news->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
