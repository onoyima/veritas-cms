@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark">Events Management</h1>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-2"></i>Add Event
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
                <form method="GET" action="{{ route('admin.events.index') }}" class="d-flex align-items-center gap-2 w-100" role="search">
                    <div class="input-group input-group-sm w-auto">
                        <span class="input-group-text bg-white"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search events...">
                    </div>
                    @if(request('search'))
                        <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-light">Clear</a>
                    @endif
                </form>
                <div class="text-muted small d-none d-md-block">
                    Showing {{ $events->firstItem() ?? 0 }}–{{ $events->lastItem() ?? 0 }} of {{ $events->total() }} results
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 border-bottom-0">Event Name / Slug</th>
                            <th class="px-4 py-3 border-bottom-0">Status</th>
                            <th class="px-4 py-3 border-bottom-0">Date & Time</th>
                            <th class="px-4 py-3 border-bottom-0">Location</th>
                            <th class="px-4 py-3 border-bottom-0">Type</th>
                            <th class="px-4 py-3 border-bottom-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($events as $event)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    @if($event->image_url)
                                        <img src="{{ $event->image_url }}" alt="" class="rounded me-3 border" style="width: 48px; height: 48px; object-fit: cover;">
                                    @else
                                        <div class="rounded bg-light d-flex align-items-center justify-content-center me-3 border" style="width: 48px; height: 48px;">
                                            <i class="fa-solid fa-calendar-day text-muted"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-semibold text-dark">{{ $event->heading }}</div>
                                        <div class="text-muted small">/{{ $event->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @if($event->is_active === \App\Enums\ActiveStatus::ACTIVE)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Active</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill">Inactive</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="small">
                                    <i class="fa-regular fa-calendar me-1 text-muted"></i>
                                    {{ $event->start_date_and_time ? $event->start_date_and_time->format('M d, Y h:i A') : 'TBD' }}
                                </div>
                                @if($event->end_date_and_time)
                                <div class="small text-muted mt-1">
                                    to {{ $event->end_date_and_time->format('M d, Y h:i A') }}
                                </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-muted small">
                                {{ $event->location ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-3">
                                <span class="badge bg-light text-dark border rounded-pill">
                                    {{ ucfirst($event->event_type) ?? 'General' }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-end">
                                <div class="btn-group">
                                    <a href="{{ route('admin.events.edit', $event->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this event?');">
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
                            <td colspan="6" class="px-4 py-5 text-center text-muted">
                                <i class="fa-solid fa-calendar-xmark fa-2x mb-3 d-block"></i>
                                No events found. Add one to get started.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($events->hasPages())
            <div class="px-4 py-3 border-top d-flex justify-content-between align-items-center">
                <div class="text-muted small">
                    Page {{ $events->currentPage() }} of {{ $events->lastPage() }}
                </div>
                {{ $events->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
