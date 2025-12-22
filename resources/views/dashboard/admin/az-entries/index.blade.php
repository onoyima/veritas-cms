@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark">A-Z Index Management</h1>
        <a href="{{ route('admin.az-entries.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-2"></i>Add Entry
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
                            <th class="px-4 py-3 border-bottom-0" style="width: 50px;">#</th>
                            <th class="px-4 py-3 border-bottom-0">Topic</th>
                            <th class="px-4 py-3 border-bottom-0">Link</th>
                            <th class="px-4 py-3 border-bottom-0">Status</th>
                            <th class="px-4 py-3 border-bottom-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($entries as $entry)
                        <tr>
                            <td class="px-4 py-3 text-center fw-bold text-muted">
                                {{ $entry->alphabet }}
                            </td>
                            <td class="px-4 py-3">
                                <div class="fw-semibold text-dark">{{ $entry->topic }}</div>
                                @if($entry->description)
                                    <div class="text-muted small text-truncate" style="max-width: 300px;">{{ $entry->description }}</div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-break" style="max-width: 250px;">
                                <a href="{{ $entry->link }}" target="_blank" class="text-decoration-none">{{ $entry->link }}</a>
                            </td>
                            <td class="px-4 py-3">
                                @if($entry->is_active === \App\Enums\ActiveStatus::ACTIVE)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Active</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill">Inactive</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-end">
                                <div class="btn-group">
                                    <a href="{{ route('admin.az-entries.edit', $entry->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.az-entries.destroy', $entry->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this entry?');">
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
                                <i class="fa-solid fa-list-ul fa-2x mb-3 d-block"></i>
                                No entries found. Add one to get started.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($entries->hasPages())
            <div class="px-4 py-3 border-top">
                {{ $entries->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
