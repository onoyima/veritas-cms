@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark">Mass Schedules Management</h1>
        <a href="{{ route('admin.mass-schedules.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-2"></i>Add Schedule
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
                            <th class="px-4 py-3 border-bottom-0">Day</th>
                            <th class="px-4 py-3 border-bottom-0">Time</th>
                            <th class="px-4 py-3 border-bottom-0">Invitees</th>
                            <th class="px-4 py-3 border-bottom-0">Status</th>
                            <th class="px-4 py-3 border-bottom-0 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($schedules as $schedule)
                        <tr>
                            <td class="px-4 py-3">
                                <span class="fw-semibold text-dark">{{ $schedule->day }}</span>
                            </td>
                            <td class="px-4 py-3">
                                {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} - 
                                {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                            </td>
                            <td class="px-4 py-3">
                                @if(is_array($schedule->invitees) && count($schedule->invitees) > 0)
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach(array_slice($schedule->invitees, 0, 3) as $invitee)
                                            <span class="badge bg-light text-dark border">{{ $invitee }}</span>
                                        @endforeach
                                        @if(count($schedule->invitees) > 3)
                                            <span class="badge bg-light text-muted border">+{{ count($schedule->invitees) - 3 }} more</span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted small">None</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($schedule->is_active === \App\Enums\ActiveStatus::ACTIVE)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill">Active</span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill">Inactive</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-end">
                                <div class="btn-group">
                                    <a href="{{ route('admin.mass-schedules.edit', $schedule->id) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.mass-schedules.destroy', $schedule->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this schedule?');">
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
                                <i class="fa-solid fa-calendar-days fa-2x mb-3 d-block"></i>
                                No schedules found. Add one to get started.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($schedules->hasPages())
            <div class="px-4 py-3 border-top">
                {{ $schedules->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
