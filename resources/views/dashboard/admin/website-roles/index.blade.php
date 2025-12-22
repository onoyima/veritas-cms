@extends('layouts.staff')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Website Role Management</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('staff.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Website Roles</li>
    </ol>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        <!-- Assign Role Section -->
        <div class="col-xl-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-user-plus me-1"></i>
                    Assign Role to Staff
                </div>
                <div class="card-body">
                    <!-- New Autocomplete Form -->
                    <form action="{{ route('admin.website-roles.store') }}" method="POST" id="roleAssignForm">
                        @csrf
                        <input type="hidden" name="staff_id" id="selected_staff_id">

                        <div class="mb-3 position-relative">
                            <label class="form-label fw-bold">Find Staff Member</label>
                            <input type="text" id="staffSearchInput" class="form-control" placeholder="Start typing name, email or staff ID..." autocomplete="off">
                            <div class="form-text">Type at least 2 characters to search.</div>

                            <!-- Dropdown for suggestions -->
                            <div id="staffSuggestions" class="list-group position-absolute w-100 shadow-lg" style="z-index: 1000; display: none; max-height: 300px; overflow-y: auto; top: 100%;"></div>
                        </div>

                        <!-- Selected Staff Display (Hidden initially) -->
                        <div id="selectedStaffCard" class="alert alert-primary d-none align-items-center justify-content-between mb-3">
                            <div>
                                <h6 class="mb-0 fw-bold" id="selectedStaffName"></h6>
                                <small id="selectedStaffEmail" class="d-block"></small>
                                <small id="selectedStaffId" class="text-uppercase text-muted" style="font-size: 0.75rem;"></small>
                            </div>
                            <button type="button" class="btn btn-sm btn-close" onclick="clearSelection()" aria-label="Clear selection"></button>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Select Role</label>
                            <select name="role_id" class="form-select" required>
                                <option value="">Choose a role...</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success w-100" id="assignBtn" disabled>
                            <i class="fas fa-check me-1"></i> Assign Role
                        </button>
                    </form>

                    <hr class="my-4">

                    <!-- Fallback / Legacy Search Form -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                         <span class="text-muted small">Not finding who you're looking for?</span>
                         <button class="btn btn-link btn-sm text-decoration-none" type="button" data-bs-toggle="collapse" data-bs-target="#legacySearch">
                            Use Advanced Search
                         </button>
                    </div>

                    <div class="collapse {{ $search ? 'show' : '' }}" id="legacySearch">
                        <form action="{{ route('admin.website-roles.index') }}" method="GET" class="mb-3">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control form-control-sm" placeholder="Search..." value="{{ $search }}">
                                <button class="btn btn-dark btn-sm" type="submit">
                                    <i class="fas fa-search me-1"></i> Search
                                </button>
                            </div>
                        </form>

                        @if($search && count($staffResults) > 0)
                        <div class="list-group list-group-flush border rounded">
                            @foreach($staffResults as $staff)
                                <button type="button" class="list-group-item list-group-item-action" onclick="selectStaff({{ json_encode($staff) }})">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold">{{ $staff->fname }} {{ $staff->lname }}</div>
                                            <small class="text-muted">{{ $staff->email }}</small>
                                        </div>
                                        <i class="fas fa-arrow-up text-primary"></i>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                        @elseif($search)
                            <div class="alert alert-info py-2 small">No results found for "{{ $search }}"</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Available Roles List -->
             <div class="card mb-4 shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <i class="fas fa-tags me-1"></i>
                    Available Roles (System Roles)
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Role Name</th>
                                    <th>Slug</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td class="ps-3 fw-medium">{{ $role->name }}</td>
                                    <td><code class="text-primary bg-light px-1 rounded">{{ $role->slug }}</code></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Current Assignments Section -->
        <div class="col-xl-6">
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-users-cog me-1"></i>
                    Current Assignments History
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Below is the history of roles currently assigned to staff members.</p>

                    @if($assignedStaff->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 40%;">Staff Member</th>
                                        <th style="width: 40%;">Assigned Roles</th>
                                        <th style="width: 20%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assignedStaff as $staff)
                                        <tr>
                                            <td>
                                                <div class="fw-bold text-dark">{{ $staff->fname }} {{ $staff->lname }}</div>
                                                <div class="small text-muted">{{ $staff->email }}</div>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-1">
                                                @foreach($staff->websiteRoles as $role)
                                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 fw-normal">
                                                        {{ $role->name }}
                                                    </span>
                                                @endforeach
                                                </div>
                                            </td>
                                            <td>
                                                @foreach($staff->websiteRoles as $role)
                                                    <form action="{{ route('admin.website-roles.destroy', ['staff' => $staff->id, 'role' => $role->id]) }}" method="POST" class="d-inline-block mb-1" onsubmit="return confirm('Are you sure you want to remove the {{ $role->name }} role from {{ $staff->fname }}?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm py-0 px-2" style="font-size: 0.75rem;" title="Remove {{ $role->name }} role">
                                                            <i class="fas fa-times me-1"></i> Revoke {{ $role->name }}
                                                        </button>
                                                    </form>
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3">
                            {{ $assignedStaff->appends(['search' => $search])->links() }}
                        </div>
                    @else
                        <div class="alert alert-light border text-center py-4">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <p class="mb-0 text-muted">No roles have been assigned to any staff yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let searchTimeout;
    const searchInput = document.getElementById('staffSearchInput');
    const suggestionsBox = document.getElementById('staffSuggestions');

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const query = this.value.trim();

        if (query.length < 2) {
            suggestionsBox.style.display = 'none';
            return;
        }

        searchTimeout = setTimeout(() => {
            fetchSuggestions(query);
        }, 300);
    });

    // Close suggestions when clicking outside
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
            suggestionsBox.style.display = 'none';
        }
    });

    function fetchSuggestions(query) {
        // Show loading state if needed
        suggestionsBox.innerHTML = '<div class="list-group-item text-muted"><i class="fas fa-spinner fa-spin me-2"></i>Searching...</div>';
        suggestionsBox.style.display = 'block';

        fetch(`{{ route('admin.website-roles.search') }}?query=${encodeURIComponent(query)}`)
            .then(response => response.json())
            .then(data => {
                if (data.length === 0) {
                    suggestionsBox.innerHTML = '<div class="list-group-item text-muted">No staff found matching "' + query + '"</div>';
                } else {
                    suggestionsBox.innerHTML = '';
                    data.forEach(staff => {
                        const item = document.createElement('a');
                        item.href = '#';
                        item.className = 'list-group-item list-group-item-action';
                        item.innerHTML = `
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <div class="fw-bold text-primary">${staff.fname} ${staff.lname}</div>
                                    <small class="text-muted">${staff.email}</small>
                                </div>
                            </div>
                        `;
                        item.onclick = (e) => {
                            e.preventDefault();
                            selectStaff(staff);
                        };
                        suggestionsBox.appendChild(item);
                    });
                }
                suggestionsBox.style.display = 'block';
            })
            .catch(error => {
                console.error('Error:', error);
                suggestionsBox.innerHTML = '<div class="list-group-item text-danger">Error fetching results</div>';
            });
    }

    function selectStaff(staff) {
        document.getElementById('selected_staff_id').value = staff.id;
        document.getElementById('selectedStaffName').textContent = staff.fname + ' ' + staff.lname;
        document.getElementById('selectedStaffEmail').textContent = staff.email;
        // document.getElementById('selectedStaffId').textContent = staff.staff_number || 'No ID';

        document.getElementById('selectedStaffCard').classList.remove('d-none');
        document.getElementById('selectedStaffCard').classList.add('d-flex');

        document.getElementById('assignBtn').disabled = false;

        // Hide search and suggestions
        searchInput.value = '';
        suggestionsBox.style.display = 'none';

        // If selecting from legacy search, collapse it
        const legacySearch = document.getElementById('legacySearch');
        if (legacySearch.classList.contains('show')) {
            new bootstrap.Collapse(legacySearch, { toggle: true });
        }
    }

    function clearSelection() {
        document.getElementById('selected_staff_id').value = '';
        document.getElementById('selectedStaffCard').classList.add('d-none');
        document.getElementById('selectedStaffCard').classList.remove('d-flex');
        document.getElementById('assignBtn').disabled = true;
        searchInput.focus();
    }
</script>
@endsection
