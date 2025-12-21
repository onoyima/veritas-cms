<div class="d-flex flex-column flex-shrink-0 text-white sidebar-gradient" style="width: 280px; min-height: 100vh;">
    <!-- Logo / Header -->
    <div class="d-flex align-items-center justify-content-center h-16 border-bottom border-secondary py-3" style="border-color: rgba(255,255,255,0.1) !important;">
        <span class="fs-4 fw-bold text-uppercase tracking-wider">Veritas CMS</span>
    </div>

    <!-- User Info (Sidebar) -->
    <div class="d-flex flex-column align-items-center mt-4 px-3">
        <div class="rounded-circle d-flex align-items-center justify-content-center overflow-hidden border border-2 border-white-50" style="width: 80px; height: 80px; background-color: rgba(255,255,255,0.1);">
            @if(auth()->guard('staff')->user()->passport_base64)
                <img src="{{ auth()->guard('staff')->user()->passport_base64 }}" alt="Profile" class="w-100 h-100 object-fit-cover">
            @else
                <span class="text-white fs-3 fw-bold">{{ substr(auth()->guard('staff')->user()->fname, 0, 1) }}{{ substr(auth()->guard('staff')->user()->lname, 0, 1) }}</span>
            @endif
        </div>
        <div class="mt-3 text-center">
            <h5 class="fw-semibold mb-0">{{ auth()->guard('staff')->user()->title }} {{ auth()->guard('staff')->user()->lname }}</h5>
            <small class="text-white-50 text-uppercase">Staff Portal</small>
        </div>
    </div>

    <hr class="text-white-50">

    <!-- Navigation -->
    <ul class="nav nav-pills flex-column mb-auto px-2">
        <li class="nav-item mb-1">
            <a href="{{ route('staff.dashboard') }}" class="nav-link text-white {{ request()->routeIs('staff.dashboard') ? 'active bg-white bg-opacity-25' : '' }}">
                <i class="fa-solid fa-gauge me-2"></i>
                Dashboard
            </a>
        </li>
        <li class="nav-item mb-1">
            <a href="{{ route('staff.profile') }}" class="nav-link text-white {{ request()->routeIs('staff.profile') ? 'active bg-white bg-opacity-25' : '' }}">
                <i class="fa-solid fa-user me-2"></i>
                My Profile
            </a>
        </li>

        @if(auth()->guard('staff')->user()->hasWebsiteRole('super-admin') || auth()->guard('staff')->user()->role == 1)
        <li class="nav-header text-uppercase text-white-50 fs-7 fw-bold mt-3 mb-2 px-3">CMS Management</li>
        
        <li class="nav-item mb-1">
            <a href="{{ route('admin.pages.index') }}" class="nav-link text-white {{ request()->routeIs('admin.pages.*') ? 'active bg-white bg-opacity-25' : '' }}">
                <i class="fa-solid fa-file-lines me-2"></i>
                Pages
            </a>
        </li>
        @endif
        
        @if(auth()->guard('staff')->user()->hasWebsiteRole('super-admin') || auth()->guard('staff')->user()->role == 1 || auth()->guard('staff')->user()->role == 5)
        
        <!-- Add more links here -->
    </ul>
</div>