<div class="d-flex flex-column flex-shrink-0 text-white w-100" style="min-height: 100%;">
    <!-- Logo / Header -->
    <div class="d-flex align-items-center justify-content-center h-16 border-bottom border-secondary py-3" style="border-color: rgba(255,255,255,0.1) !important;">
        <span class="fs-4 fw-bold text-uppercase tracking-wider">Veritas CMS</span>
    </div>

    <!-- Navigation -->
    <ul class="nav nav-pills flex-column mb-auto px-2 mt-3 pb-5" style="overflow-y: visible;">
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

        <!-- Pages (Collapsible Submenu) -->
        <li class="nav-item mb-1">
            <a href="#pagesSubmenu" data-bs-toggle="collapse" class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->routeIs('admin.pages.*') ? 'active bg-white bg-opacity-25' : '' }}" role="button" aria-expanded="{{ request()->routeIs('admin.pages.*') ? 'true' : 'false' }}" aria-controls="pagesSubmenu">
                <span>
                    <i class="fa-solid fa-file-lines me-2"></i>
                    Pages
                </span>
                <i class="fa-solid fa-chevron-down fs-8"></i>
            </a>
            <div class="collapse {{ request()->routeIs('admin.pages.*') ? 'show' : '' }}" id="pagesSubmenu">
                <ul class="nav flex-column ms-3 mt-1 border-start border-white border-opacity-25 ps-2">
                    <li class="nav-item">
                        <a href="{{ route('admin.pages.index') }}" class="nav-link text-white py-1 fs-7 {{ request()->routeIs('admin.pages.index') ? 'fw-bold text-warning' : '' }}">
                            All Pages
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.pages.create') }}" class="nav-link text-white py-1 fs-7 {{ request()->routeIs('admin.pages.create') ? 'fw-bold text-warning' : '' }}">
                            Add New Page
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <!-- Website Content (Collapsible Submenu) -->
        <li class="nav-item mb-1">
            <a href="#contentSubmenu" data-bs-toggle="collapse" class="nav-link text-white d-flex justify-content-between align-items-center {{ request()->routeIs('admin.news.*') || request()->routeIs('admin.events.*') || request()->routeIs('admin.personnel.*') || request()->routeIs('admin.student-groups.*') || request()->routeIs('admin.courses.*') || request()->routeIs('admin.programs.*') || request()->routeIs('admin.publications.*') || request()->routeIs('admin.research-groups.*') || request()->routeIs('admin.mass-schedules.*') || request()->routeIs('admin.faqs.*') || request()->routeIs('admin.az-entries.*') ? 'active bg-white bg-opacity-25' : '' }}" role="button" aria-expanded="{{ request()->routeIs('admin.news.*') || request()->routeIs('admin.events.*') ? 'true' : 'false' }}" aria-controls="contentSubmenu">
                <span>
                    <i class="fa-solid fa-layer-group me-2"></i>
                    Website Content
                </span>
                <i class="fa-solid fa-chevron-down fs-8"></i>
            </a>
            <div class="collapse {{ request()->routeIs('admin.news.*') || request()->routeIs('admin.events.*') || request()->routeIs('admin.personnel.*') || request()->routeIs('admin.student-groups.*') || request()->routeIs('admin.courses.*') || request()->routeIs('admin.programs.*') || request()->routeIs('admin.publications.*') || request()->routeIs('admin.research-groups.*') || request()->routeIs('admin.mass-schedules.*') || request()->routeIs('admin.faqs.*') || request()->routeIs('admin.az-entries.*') ? 'show' : '' }}" id="contentSubmenu">
                <ul class="nav flex-column ms-3 mt-1 border-start border-white border-opacity-25 ps-2">
                    <li class="nav-item">
                        <a href="{{ route('admin.news.index') }}" class="nav-link text-white py-1 fs-7 {{ request()->routeIs('admin.news.*') ? 'fw-bold text-warning' : '' }}">
                            News
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.events.index') }}" class="nav-link text-white py-1 fs-7 {{ request()->routeIs('admin.events.*') ? 'fw-bold text-warning' : '' }}">
                            Events
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.personnel.index') }}" class="nav-link text-white py-1 fs-7 {{ request()->routeIs('admin.personnel.*') ? 'fw-bold text-warning' : '' }}">
                            Personnel
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.student-groups.index') }}" class="nav-link text-white py-1 fs-7 {{ request()->routeIs('admin.student-groups.*') ? 'fw-bold text-warning' : '' }}">
                            Student Groups
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.courses.index') }}" class="nav-link text-white py-1 fs-7 {{ request()->routeIs('admin.courses.*') ? 'fw-bold text-warning' : '' }}">
                            Courses
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.programs.index') }}" class="nav-link text-white py-1 fs-7 {{ request()->routeIs('admin.programs.*') ? 'fw-bold text-warning' : '' }}">
                            Programs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.publications.index') }}" class="nav-link text-white py-1 fs-7 {{ request()->routeIs('admin.publications.*') ? 'fw-bold text-warning' : '' }}">
                            Publications
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.research-groups.index') }}" class="nav-link text-white py-1 fs-7 {{ request()->routeIs('admin.research-groups.*') ? 'fw-bold text-warning' : '' }}">
                            Research Groups
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.mass-schedules.index') }}" class="nav-link text-white py-1 fs-7 {{ request()->routeIs('admin.mass-schedules.*') ? 'fw-bold text-warning' : '' }}">
                            Mass Schedules
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.faqs.index') }}" class="nav-link text-white py-1 fs-7 {{ request()->routeIs('admin.faqs.*') ? 'fw-bold text-warning' : '' }}">
                            FAQs
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.az-entries.index') }}" class="nav-link text-white py-1 fs-7 {{ request()->routeIs('admin.az-entries.*') ? 'fw-bold text-warning' : '' }}">
                            A-Z Index
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        @endif

        <!-- Role Management (Super Admin Only) -->
        @if(auth()->guard('staff')->user()->hasWebsiteRole('super-admin') || auth()->guard('staff')->user()->role == 1)
        <li class="nav-header text-uppercase text-white-50 fs-7 fw-bold mt-3 mb-2 px-3">Administration</li>
        <li class="nav-item mb-1">
            <a href="{{ route('admin.website-roles.index') }}" class="nav-link text-white {{ request()->routeIs('admin.website-roles.*') ? 'active bg-white bg-opacity-25' : '' }}">
                <i class="fa-solid fa-user-shield me-2"></i>
                Role Assignment
            </a>
        </li>
        @endif

        <!-- Help & Documentation -->
        <li class="nav-item mt-3 border-top border-white border-opacity-10 pt-3">
            <a href="{{ route('staff.help') }}" class="nav-link text-white d-flex align-items-center {{ request()->routeIs('staff.help') ? 'active bg-white bg-opacity-25' : '' }}">
                <i class="fa-solid fa-circle-question me-2"></i>
                Help & Support
            </a>
        </li>

        <!-- Logout -->
        <li class="nav-item mt-1">
            <form method="POST" action="{{ route('staff.logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="nav-link text-white d-flex align-items-center bg-transparent border-0 w-100">
                    <i class="fa-solid fa-power-off me-2 text-danger"></i>
                    Logout
                </button>
            </form>
        </li>

        <!-- Spacer to ensure scrolling -->
        <li class="nav-item" style="height: 100px;"></li>
    </ul>
</div>
