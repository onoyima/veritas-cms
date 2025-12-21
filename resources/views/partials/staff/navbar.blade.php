<nav class="navbar navbar-expand-lg navbar-light sticky-top glass-header border-bottom shadow-sm px-4">
    <div class="container-fluid p-0">
        <!-- Sidebar Toggle (Mobile) -->
        <button class="btn btn-link text-dark d-lg-none me-3" id="sidebarToggle">
            <i class="fa-solid fa-bars"></i>
        </button>

        <!-- Mobile Toggle (if needed) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="rounded-circle d-flex align-items-center justify-content-center overflow-hidden bg-secondary me-2" style="width: 32px; height: 32px;">
                             @if(auth()->guard('staff')->user()->passport_base64)
                                <img src="{{ auth()->guard('staff')->user()->passport_base64 }}" alt="Profile" class="w-100 h-100 object-fit-cover">
                            @else
                                <span class="text-white small fw-bold">{{ substr(auth()->guard('staff')->user()->fname, 0, 1) }}{{ substr(auth()->guard('staff')->user()->lname, 0, 1) }}</span>
                            @endif
                        </div>
                        <span class="fw-medium text-dark">{{ auth()->guard('staff')->user()->fname }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="{{ route('staff.profile') }}">Your Profile</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('staff.logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Sign out</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
