<div class="d-flex flex-column flex-shrink-0 text-white sidebar-gradient h-100 w-100">
    <!-- Logo / Header -->
    <div class="d-flex align-items-center justify-content-center h-16 border-bottom border-secondary py-3" style="border-color: rgba(255,255,255,0.1) !important;">
        <span class="fs-4 fw-bold text-uppercase tracking-wider">Veritas CMS</span>
    </div>

    <!-- Navigation -->
    <ul class="nav nav-pills flex-column mb-auto px-2 mt-3">
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

        @if(auth()->guard('staff')->user()->hasWebsiteRole('super-admin') || auth()->guard('staff')->user()->hasWebsiteRole('editor') || auth()->guard('staff')->user()->role == 1)
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
        @endif
    </ul>
</div>
