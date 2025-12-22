@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark">Research Groups Management</h1>
        <a href="{{ route('admin.research-groups.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-2"></i>Add Research Group
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
                            <th class="px-4 py-3 border-bottom-0">Group Info</th>
                            <th class="px-4 py-3 border-bottom-0">Researchers</th>
                            <th class="px-4 py-3 border-bottom-0">Publications</th>
                            <th class="px-4 py-3 border-bottom-0">Status</th>
                            <th class="px-4 py-3 border-bottom-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($groups as $group)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    @if($group->image_url)
                                        <img src="{{ $group->image_url }}" alt="" class="rounded me-3 border" style="width: 48px; height: 48px; object-fit: cover;">
                                    @else
                                        <div class="rounded bg-light d-flex align-items-center justify-content-center me-3 border" style="width: 48px; height: 48px;">
                                            <i class="fa-solid fa-users text-muted"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-semibold text-dark">{{ $group->title }}</div>
                                        <div class="text-muted small">/{{ $group->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge bg-light text-dark border">{{ $group->researchers_count ?? $group->researchers()->count() }} Members</span>
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge bg-light text-dark border">{{ $group->publications_count ?? $group->publications()->count() }} Publications</span>
                            </td>
                            <td class="px-4 py-3">
                                @if($group->is_active === \App\Enums\ActiveStatus::ACTIVE)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Active</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill">Inactive</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-end">
                                <div class="btn-group">
                                    <a href="{{ route('admin.research-groups.edit', $group->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.research-groups.destroy', $group->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this group?');">
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
                                <i class="fa-solid fa-flask fa-2x mb-3 d-block"></i>
                                No research groups found. Add one to get started.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($groups->hasPages())
            <div class="px-4 py-3 border-top">
                {{ $groups->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
