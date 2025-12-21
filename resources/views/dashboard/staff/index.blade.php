@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <!-- Welcome Section -->
    <div class="card border-0 shadow-sm mb-4 border-start border-5 border-success" style="border-left-color: #114629 !important;">
        <div class="card-body p-4">
            <h1 class="h3 fw-bold text-dark">Welcome to your Dashboard, {{ $staff->title }} {{ $staff->lname }}!</h1>
            <p class="text-muted mb-0">Role: 
                @if($staff->role == 1 || $staff->hasWebsiteRole('super-admin'))
                    <span class="badge bg-danger">Super Admin</span>
                @elseif($staff->role == 5)
                    <span class="badge bg-primary">Management</span>
                @elseif($staff->role == 3)
                    <span class="badge bg-success">Staff</span>
                @else
                    <span class="badge bg-secondary">Guest</span>
                @endif
            </p>
        </div>
    </div>

    <!-- Dashboard Widgets Based on Role -->
    <div class="row g-4">
        <!-- Common Widget for All Staff -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 bg-primary text-white">
                <div class="card-body text-center">
                    <i class="fa-solid fa-bullhorn fa-3x mb-3 text-white-50"></i>
                    <h5 class="card-title">Announcements</h5>
                    <p class="card-text">Check latest updates</p>
                </div>
            </div>
        </div>

        @if($staff->role == 1 || $staff->hasWebsiteRole('super-admin'))
        <!-- Admin Widgets -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 bg-dark text-white">
                <div class="card-body text-center">
                    <i class="fa-solid fa-file-lines fa-3x mb-3 text-white-50"></i>
                    <h5 class="card-title">Pages</h5>
                    <h2 class="display-4 fw-bold">{{ $stats['pages'] ?? 0 }}</h2>
                    <p class="card-text">Total Pages</p>
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-sm btn-light mt-2">Manage Pages</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 bg-info text-white">
                <div class="card-body text-center">
                    <i class="fa-solid fa-users fa-3x mb-3 text-white-50"></i>
                    <h5 class="card-title">Staff</h5>
                    <h2 class="display-4 fw-bold">{{ $stats['staff_count'] ?? 0 }}</h2>
                    <p class="card-text">Total Staff</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 bg-warning text-dark">
                <div class="card-body text-center">
                    <i class="fa-solid fa-graduation-cap fa-3x mb-3 text-dark-50"></i>
                    <h5 class="card-title">Students</h5>
                    <h2 class="display-4 fw-bold">{{ $stats['students'] ?? 0 }}</h2>
                    <p class="card-text">Total Students</p>
                </div>
            </div>
        </div>
        @endif

        @if($staff->role == 3 || $staff->role == 5) <!-- Staff or Management -->
        <!-- Academic Widgets -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 bg-success text-white">
                <div class="card-body text-center">
                    <i class="fa-solid fa-book-open fa-3x mb-3 text-white-50"></i>
                    <h5 class="card-title">My Courses</h5>
                    <p class="card-text">View assigned courses</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 bg-info text-white">
                <div class="card-body text-center">
                    <i class="fa-solid fa-calendar-check fa-3x mb-3 text-white-50"></i>
                    <h5 class="card-title">Attendance</h5>
                    <p class="card-text">Mark student attendance</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection