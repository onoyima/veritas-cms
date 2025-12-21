<div class="d-flex flex-column flex-shrink-0 text-white sidebar-gradient" style="width: 280px; min-height: 100vh;">
    <!-- Logo / Header -->
    <div class="d-flex align-items-center justify-content-center h-16 border-bottom border-secondary py-3" style="border-color: rgba(255,255,255,0.1) !important;">
        <span class="fs-4 fw-bold text-uppercase tracking-wider">Veritas Student</span>
    </div>

    <!-- User Info (Sidebar) -->
    <div class="d-flex flex-column align-items-center mt-4 px-3">
        <div class="rounded-circle d-flex align-items-center justify-content-center overflow-hidden border border-2 border-white-50" style="width: 80px; height: 80px; background-color: rgba(255,255,255,0.1);">
            @if(auth()->guard('student')->user()->passport_base64)
                <img src="{{ auth()->guard('student')->user()->passport_base64 }}" alt="Profile" class="w-100 h-100 object-fit-cover">
            @else
                <span class="text-white fs-3 fw-bold">{{ substr(auth()->guard('student')->user()->fname, 0, 1) }}{{ substr(auth()->guard('student')->user()->lname, 0, 1) }}</span>
            @endif
        </div>
        <div class="mt-3 text-center">
            <h5 class="fw-semibold mb-0">{{ auth()->guard('student')->user()->fname }} {{ auth()->guard('student')->user()->lname }}</h5>
            <small class="text-white-50 text-uppercase">{{ auth()->guard('student')->user()->matric_no ?? 'No Matric No' }}</small>
        </div>
    </div>

    <hr class="text-white-50">

    <!-- Navigation -->
    <ul class="nav nav-pills flex-column mb-auto px-2">
        <li class="nav-item mb-1">
            <a href="{{ route('student.dashboard') }}" class="nav-link text-white {{ request()->routeIs('student.dashboard') ? 'active bg-white bg-opacity-25' : '' }}">
                <i class="fa-solid fa-gauge me-2"></i>
                Dashboard
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="{{ route('student.profile') }}" class="nav-link text-white {{ request()->routeIs('student.profile') ? 'active bg-white bg-opacity-25' : '' }}">
                <i class="fa-solid fa-user me-2"></i>
                My Profile
            </a>
        </li>
        
        <!-- Add more links here -->
    </ul>
</div>