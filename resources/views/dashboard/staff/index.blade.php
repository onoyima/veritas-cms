@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <!-- Header / Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-white overflow-hidden rounded-4">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-md-8 p-4 p-md-5">
                            <h5 class="text-success text-uppercase fw-bold letter-spacing-1 mb-2">Dashboard</h5>
                            <h1 class="display-6 fw-bold text-dark mb-3">
                                Welcome back, {{ $staff->fname }}!
                            </h1>
                            <p class="text-muted lead mb-4">
                                Here's what's happening with your content and students today.
                            </p>
                            <div class="d-flex align-items-center gap-3">
                                <span class="badge rounded-pill bg-light text-dark border px-3 py-2">
                                    <i class="fa-solid fa-calendar-day me-2 text-success"></i> {{ now()->format('l, F j, Y') }}
                                </span>
                                <span class="badge rounded-pill bg-light text-dark border px-3 py-2">
                                    <i class="fa-solid fa-user-tag me-2 text-primary"></i>
                                    @if($staff->role == 1 || $staff->hasWebsiteRole('super-admin'))
                                        Super Admin
                                    @elseif($staff->role == 5)
                                        Management
                                    @elseif($staff->role == 3)
                                        Academic Staff
                                    @else
                                        Guest
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="col-md-4 d-none d-md-block position-relative bg-success bg-opacity-10">
                            <!-- Decorative Circle -->
                            <div class="position-absolute top-50 start-50 translate-middle rounded-circle bg-success bg-opacity-25" style="width: 300px; height: 300px; filter: blur(50px);"></div>
                            <div class="h-100 d-flex align-items-center justify-content-center position-relative z-1">
                                <i class="fa-solid fa-chart-line fa-6x text-success opacity-50"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="row g-4 mb-4">
        <!-- Students -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift transition-all">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="rounded-3 bg-primary bg-opacity-10 p-3">
                            <i class="fa-solid fa-user-graduate fa-xl text-primary"></i>
                        </div>
                        @if(isset($stats['students']))
                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-2 py-1">
                            <i class="fa-solid fa-arrow-up small me-1"></i>Active
                        </span>
                        @endif
                    </div>
                    <h2 class="fw-bold text-dark mb-1">{{ number_format($stats['students'] ?? 0) }}</h2>
                    <p class="text-muted small mb-0 text-uppercase tracking-wide">Total Students</p>
                </div>
            </div>
        </div>

        <!-- Staff -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift transition-all">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="rounded-3 bg-warning bg-opacity-10 p-3">
                            <i class="fa-solid fa-chalkboard-user fa-xl text-warning"></i>
                        </div>
                        <span class="badge bg-light text-dark rounded-pill px-2 py-1 border">Faculty</span>
                    </div>
                    <h2 class="fw-bold text-dark mb-1">{{ number_format($stats['staff_count'] ?? 0) }}</h2>
                    <p class="text-muted small mb-0 text-uppercase tracking-wide">Total Staff</p>
                </div>
            </div>
        </div>

        <!-- News/Content -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift transition-all">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="rounded-3 bg-danger bg-opacity-10 p-3">
                            <i class="fa-solid fa-newspaper fa-xl text-danger"></i>
                        </div>
                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-2 py-1">Published</span>
                    </div>
                    <h2 class="fw-bold text-dark mb-1">{{ number_format($stats['news'] ?? 0) }}</h2>
                    <p class="text-muted small mb-0 text-uppercase tracking-wide">News Articles</p>
                </div>
            </div>
        </div>

        <!-- Pages/System -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-lift transition-all">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="rounded-3 bg-info bg-opacity-10 p-3">
                            <i class="fa-solid fa-layer-group fa-xl text-info"></i>
                        </div>
                        <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-2 py-1">CMS</span>
                    </div>
                    <h2 class="fw-bold text-dark mb-1">{{ number_format($stats['pages'] ?? 0) }}</h2>
                    <p class="text-muted small mb-0 text-uppercase tracking-wide">Total Pages</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row g-4 mb-4">
        <!-- Bar Chart: Content Overview -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">Content Overview</h5>
                    <button class="btn btn-sm btn-light border rounded-pill px-3">
                        <i class="fa-solid fa-download me-2"></i>Report
                    </button>
                </div>
                <div class="card-body p-4">
                    <canvas id="contentChart" height="120"></canvas>
                </div>
            </div>
        </div>

        <!-- Pie Chart: User Distribution -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                    <h5 class="fw-bold text-dark mb-0">User Distribution</h5>
                </div>
                <div class="card-body p-4 d-flex flex-column justify-content-center align-items-center">
                    <div style="width: 100%; max-width: 250px;">
                        <canvas id="userChart"></canvas>
                    </div>
                    <div class="mt-4 text-center w-100">
                        <div class="d-flex justify-content-between small text-muted border-bottom pb-2 mb-2">
                            <span>Students</span>
                            <span class="fw-bold text-dark">{{ number_format($stats['students'] ?? 0) }}</span>
                        </div>
                        <div class="d-flex justify-content-between small text-muted">
                            <span>Staff</span>
                            <span class="fw-bold text-dark">{{ number_format($stats['staff_count'] ?? 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Quick Actions -->
    <div class="row g-4">
        <!-- Recent News -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold text-dark mb-0">Recent News</h5>
                    <a href="{{ route('admin.news.index') }}" class="btn btn-sm btn-link text-decoration-none">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 border-0 text-muted small text-uppercase font-weight-bold">Title</th>
                                    <th class="border-0 text-muted small text-uppercase font-weight-bold">Date</th>
                                    <th class="border-0 text-muted small text-uppercase font-weight-bold">Status</th>
                                    <th class="pe-4 border-0 text-muted small text-uppercase font-weight-bold text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recent_news as $news)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded bg-light d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="fa-regular fa-newspaper text-muted"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 text-dark fw-medium text-truncate" style="max-width: 250px;">{{ $news->title }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-muted small">
                                        {{ $news->created_at->format('M d, Y') }}
                                    </td>
                                    <td>
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill">Published</span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <a href="{{ route('admin.news.edit', $news->id) }}" class="btn btn-sm btn-light border rounded-circle" data-bs-toggle="tooltip" title="Edit">
                                            <i class="fa-solid fa-pen small"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">No recent news found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-dark text-white overflow-hidden position-relative">
                <div class="position-absolute top-0 end-0 p-3 opacity-10">
                    <i class="fa-solid fa-rocket fa-8x text-white"></i>
                </div>
                <div class="card-body p-4 position-relative z-1">
                    <h5 class="fw-bold mb-4">Quick Actions</h5>
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.news.create') }}" class="btn btn-light text-start p-3 border-0 rounded-3 hover-scale transition-all d-flex align-items-center justify-content-between">
                            <span class="fw-medium text-dark"><i class="fa-solid fa-plus-circle text-success me-2"></i> Post News</span>
                            <i class="fa-solid fa-chevron-right text-muted small"></i>
                        </a>
                        <a href="{{ route('admin.events.create') }}" class="btn btn-white bg-opacity-10 text-white text-start p-3 border border-secondary rounded-3 hover-scale transition-all d-flex align-items-center justify-content-between">
                            <span class="fw-medium"><i class="fa-solid fa-calendar-plus text-warning me-2"></i> Create Event</span>
                            <i class="fa-solid fa-chevron-right text-white-50 small"></i>
                        </a>
                        <a href="{{ route('staff.profile') }}" class="btn btn-white bg-opacity-10 text-white text-start p-3 border border-secondary rounded-3 hover-scale transition-all d-flex align-items-center justify-content-between">
                            <span class="fw-medium"><i class="fa-solid fa-user-gear text-info me-2"></i> Update Profile</span>
                            <i class="fa-solid fa-chevron-right text-white-50 small"></i>
                        </a>
                        <a href="{{ route('staff.help') }}" class="btn btn-white bg-opacity-10 text-white text-start p-3 border border-secondary rounded-3 hover-scale transition-all d-flex align-items-center justify-content-between">
                            <span class="fw-medium"><i class="fa-solid fa-circle-question text-light me-2"></i> Help Center</span>
                            <i class="fa-solid fa-chevron-right text-white-50 small"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Shared Chart Options
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { family: "'Instrument Sans', sans-serif", size: 12 },
                        usePointStyle: true,
                        padding: 20
                    }
                }
            }
        };

        // Content Bar Chart
        const ctxContent = document.getElementById('contentChart').getContext('2d');
        new Chart(ctxContent, {
            type: 'bar',
            data: {
                labels: ['Pages', 'News', 'Events', 'Programs', 'Courses'],
                datasets: [{
                    label: 'Total Items',
                    data: [
                        {{ $stats['pages'] ?? 0 }},
                        {{ $stats['news'] ?? 0 }},
                        {{ $stats['events'] ?? 0 }},
                        {{ $stats['programs'] ?? 0 }},
                        {{ $stats['courses'] ?? 0 }}
                    ],
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)',
                        'rgba(153, 102, 255, 0.7)'
                    ],
                    borderRadius: 6,
                    barThickness: 30
                }]
            },
            options: {
                ...commonOptions,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { display: true, borderDash: [5, 5] }
                    },
                    x: {
                        grid: { display: false }
                    }
                }
            }
        });

        // User Doughnut Chart
        const ctxUser = document.getElementById('userChart').getContext('2d');
        new Chart(ctxUser, {
            type: 'doughnut',
            data: {
                labels: ['Students', 'Staff'],
                datasets: [{
                    data: [
                        {{ $stats['students'] ?? 0 }},
                        {{ $stats['staff_count'] ?? 0 }}
                    ],
                    backgroundColor: [
                        '#114629', // Brand Green
                        '#ffc107'  // Warning/Secondary
                    ],
                    borderWidth: 0,
                    hoverOffset: 4
                }]
            },
            options: {
                ...commonOptions,
                cutout: '70%',
                plugins: {
                    ...commonOptions.plugins,
                    legend: { display: false } // Custom legend in HTML
                }
            }
        });
    });
</script>

<style>
    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
    }
    .hover-scale:hover {
        transform: scale(1.02);
    }
    .letter-spacing-1 {
        letter-spacing: 1px;
    }
</style>
@endsection
