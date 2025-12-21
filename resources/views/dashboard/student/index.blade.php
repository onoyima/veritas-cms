@extends('layouts.student')

@section('content')
<div class="container-fluid p-0">
    <!-- Welcome Section -->
    <div class="card border-0 shadow-sm mb-4 border-start border-5 border-success" style="border-left-color: #114629 !important;">
        <div class="card-body p-4">
            <h1 class="h3 fw-bold text-dark">Welcome back, {{ $student->fname }}!</h1>
            <p class="text-muted mb-0">Matric No: {{ $student->matric_no ?? 'Pending' }}</p>
        </div>
    </div>

    <!-- Student Dashboard Widgets -->
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 bg-primary text-white">
                <div class="card-body text-center">
                    <i class="fa-solid fa-graduation-cap fa-3x mb-3 text-white-50"></i>
                    <h5 class="card-title">My Courses</h5>
                    <p class="card-text">View registered courses</p>
                    <a href="#" class="stretched-link"></a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 bg-success text-white">
                <div class="card-body text-center">
                    <i class="fa-solid fa-scroll fa-3x mb-3 text-white-50"></i>
                    <h5 class="card-title">Results</h5>
                    <p class="card-text">Check your grades</p>
                    <a href="#" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 bg-warning text-dark">
                <div class="card-body text-center">
                    <i class="fa-solid fa-money-bill-wave fa-3x mb-3 text-dark-50"></i>
                    <h5 class="card-title">Fees</h5>
                    <p class="card-text">Payment history</p>
                    <a href="#" class="stretched-link"></a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 bg-info text-white">
                <div class="card-body text-center">
                    <i class="fa-solid fa-bed fa-3x mb-3 text-white-50"></i>
                    <h5 class="card-title">Hostel</h5>
                    <p class="card-text">Accommodation status</p>
                    <a href="#" class="stretched-link"></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection