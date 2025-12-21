@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark">My Profile</h1>
            <p class="text-muted mb-0">Manage your personal and work information.</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Personal Information Card -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-light border-bottom py-3">
                    <h5 class="card-title mb-0 fw-semibold text-dark">Personal Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Full Name</label>
                            <div class="fw-medium">{{ $staff->title }} {{ $staff->fname }} {{ $staff->mname }} {{ $staff->lname }}</div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Email</label>
                            <div class="fw-medium">{{ $staff->email }}</div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Phone</label>
                            <div class="fw-medium">{{ $staff->phone ?? 'N/A' }}</div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Gender</label>
                            <div class="fw-medium">{{ $staff->gender ?? 'N/A' }}</div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Date of Birth</label>
                            <div class="fw-medium">{{ $staff->dob ?? 'N/A' }}</div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Marital Status</label>
                            <div class="fw-medium">{{ $staff->marital_status ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Work Profile Card -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                 <div class="card-header bg-light border-bottom py-3">
                    <h5 class="card-title mb-0 fw-semibold text-dark">Work Profile</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Staff ID</label>
                            <div class="fw-medium">{{ $staff->staff_work_profile->staff_id_number ?? 'N/A' }}</div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Department</label>
                            <div class="fw-medium">{{ $staff->staff_work_profile->department_id ?? 'N/A' }}</div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Designation</label>
                            <div class="fw-medium">{{ $staff->staff_work_profile->designation ?? 'N/A' }}</div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Appointment Date</label>
                            <div class="fw-medium">{{ $staff->staff_work_profile->appointment_date ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <!-- Contact Information Card -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                 <div class="card-header bg-light border-bottom py-3">
                    <h5 class="card-title mb-0 fw-semibold text-dark">Contact Details</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Address</label>
                            <div class="fw-medium">{{ $staff->staff_contact->address ?? $staff->address ?? 'N/A' }}</div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">State</label>
                            <div class="fw-medium">{{ $staff->staff_contact->state ?? $staff->state_id ?? 'N/A' }}</div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Next of Kin</label>
                            <div class="fw-medium">{{ $staff->staff_contact->name ?? 'N/A' }} ({{ $staff->staff_contact->relationship ?? 'N/A' }})</div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Next of Kin Phone</label>
                            <div class="fw-medium">{{ $staff->staff_contact->phone_no ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection