@extends('layouts.student')

@section('content')
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark">My Profile</h1>
            <p class="text-muted mb-0">View your personal, academic, and medical information.</p>
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
                            <div class="fw-medium">{{ $student->fname }} {{ $student->mname }} {{ $student->lname }}</div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Matric No</label>
                            <div class="fw-medium">{{ $student->matric_no ?? 'N/A' }}</div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Email</label>
                            <div class="fw-medium">{{ $student->email }}</div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Phone</label>
                            <div class="fw-medium">{{ $student->phone ?? 'N/A' }}</div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Gender</label>
                            <div class="fw-medium">{{ $student->gender ?? 'N/A' }}</div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Date of Birth</label>
                            <div class="fw-medium">{{ $student->dob ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Academic Information Card -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                 <div class="card-header bg-light border-bottom py-3">
                    <h5 class="card-title mb-0 fw-semibold text-dark">Academic Information</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Level</label>
                            <div class="fw-medium">{{ $student->student_academic->level ?? 'N/A' }}</div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Program</label>
                            <div class="fw-medium">{{ $student->student_academic->program_id ?? 'N/A' }}</div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Session</label>
                            <div class="fw-medium">{{ $student->student_academic->session ?? 'N/A' }}</div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Admission Year</label>
                            <div class="fw-medium">{{ $student->student_academic->admission_year ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

         <!-- Medical & Contact Card -->
        <div class="col-lg-4 col-md-6">
            <div class="card border-0 shadow-sm h-100">
                 <div class="card-header bg-light border-bottom py-3">
                    <h5 class="card-title mb-0 fw-semibold text-dark">Medical & Contact</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Blood Group</label>
                            <div class="fw-medium">{{ $student->student_medical->blood_group ?? 'N/A' }}</div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Genotype</label>
                            <div class="fw-medium">{{ $student->student_medical->genotype ?? 'N/A' }}</div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Parent/Guardian</label>
                            <div class="fw-medium">{{ $student->student_contact->guardian_name ?? 'N/A' }}</div>
                        </div>
                        <div class="col-12">
                            <label class="small text-muted fw-bold text-uppercase">Guardian Phone</label>
                            <div class="fw-medium">{{ $student->student_contact->guardian_phone ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection