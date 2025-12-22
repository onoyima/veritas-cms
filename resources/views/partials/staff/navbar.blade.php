<nav class="navbar navbar-expand-lg navbar-light sticky-top glass-header border-bottom shadow-sm px-4">
    <div class="container-fluid p-0 d-flex justify-content-between align-items-center">
        <!-- Sidebar Toggle (Mobile) -->
        <button class="btn btn-link text-dark d-lg-none me-3 p-0" id="sidebarToggle">
            <i class="fa-solid fa-bars fa-lg"></i>
        </button>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 flex-row">
            <li class="nav-item dropdown">
                <a class="nav-link d-flex align-items-center gap-2 p-1 rounded-pill border-0 hover-bg-light transition-all" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="rounded-circle d-flex align-items-center justify-content-center overflow-hidden bg-success text-white shadow-sm" style="width: 38px; height: 38px; border: 2px solid #fff;">
                         @if(auth()->guard('staff')->user()->passport_base64)
                            <img src="{{ auth()->guard('staff')->user()->passport_base64 }}" alt="Profile" class="w-100 h-100 object-fit-cover">
                        @else
                            <span class="small fw-bold">{{ substr(auth()->guard('staff')->user()->fname, 0, 1) }}{{ substr(auth()->guard('staff')->user()->lname, 0, 1) }}</span>
                        @endif
                    </div>
                    <!-- Name visible on Desktop -->
                    <span class="fw-medium text-dark d-none d-lg-block me-2">{{ auth()->guard('staff')->user()->fname }}</span>
                    <!-- Down Arrow visible on Mobile -->
                    <i class="fa-solid fa-chevron-down text-secondary fs-7 d-lg-none me-1"></i>
                </a>

                <!-- Dropdown Menu -->
                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg mt-2 rounded-4 overflow-hidden animate-slide-in" aria-labelledby="navbarDropdown" style="min-width: 260px;">
                    <!-- Mobile User Header -->
                    <li class="d-lg-none bg-light p-3 border-bottom">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center overflow-hidden bg-success text-white" style="width: 48px; height: 48px;">
                                @if(auth()->guard('staff')->user()->passport_base64)
                                    <img src="{{ auth()->guard('staff')->user()->passport_base64 }}" alt="Profile" class="w-100 h-100 object-fit-cover">
                                @else
                                    <span class="fw-bold">{{ substr(auth()->guard('staff')->user()->fname, 0, 1) }}{{ substr(auth()->guard('staff')->user()->lname, 0, 1) }}</span>
                                @endif
                            </div>
                            <div>
                                <span class="fw-bold text-dark d-block">{{ auth()->guard('staff')->user()->fname }} {{ auth()->guard('staff')->user()->lname }}</span>
                                <span class="small text-muted text-truncate d-block" style="max-width: 150px;">{{ auth()->guard('staff')->user()->email }}</span>
                            </div>
                        </div>
                    </li>

                    <li class="p-1">
                        <a class="dropdown-item py-2 px-3 rounded-3 d-flex align-items-center gap-3" href="{{ route('staff.profile') }}">
                            <div class="icon-square bg-primary bg-opacity-10 text-primary rounded-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="fa-regular fa-user"></i>
                            </div>
                            <div>
                                <span class="d-block fw-medium">Your Profile</span>
                                <span class="small text-muted d-block">View personal details</span>
                            </div>
                        </a>
                    </li>
                    <li class="p-1">
                        <a class="dropdown-item py-2 px-3 rounded-3 d-flex align-items-center gap-3" href="#">
                            <div class="icon-square bg-info bg-opacity-10 text-info rounded-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="fa-solid fa-gear"></i>
                            </div>
                            <div>
                                <span class="d-block fw-medium">Settings</span>
                                <span class="small text-muted d-block">Account preferences</span>
                            </div>
                        </a>
                    </li>
                    <li><hr class="dropdown-divider my-1"></li>
                    <li class="p-1">
                        <form method="POST" action="{{ route('staff.logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 px-3 rounded-3 d-flex align-items-center gap-3 text-danger">
                                <div class="icon-square bg-danger bg-opacity-10 text-danger rounded-2 d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                </div>
                                <span class="fw-medium">Sign out</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<style>
    .hover-bg-light:hover {
        background-color: rgba(0,0,0,0.05);
    }

    .icon-square {
        flex-shrink: 0;
    }

    /* Mobile specific dropdown improvements */
    @media (max-width: 991.98px) {
        .dropdown-menu {
            position: absolute !important;
            width: 90vw; /* Wide but not full width */
            right: -10px !important; /* Align slightly off-right */
            left: auto !important;
            top: 100% !important;
            margin-top: 10px !important;
        }

        .animate-slide-in {
            animation: slideInDown 0.2s ease-out forwards;
        }
    }

    @keyframes slideInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
