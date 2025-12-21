@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark">Add Personnel</h1>
        <a href="{{ route('admin.personnel.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.personnel.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4 mb-4">
                    <div class="col-md-8">
                        <div class="row mb-3">
                            <div class="col-md-2">
                                <label for="title" class="form-label fw-bold">Title</label>
                                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Dr.">
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-10">
                                <label for="name" class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="position" class="form-label fw-bold">Position / Job Title</label>
                            <input type="text" name="position" id="position" class="form-control @error('position') is-invalid @enderror" value="{{ old('position') }}">
                            @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-bold">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="phone_number" class="form-label fw-bold">Phone Number</label>
                                <input type="text" name="phone_number" id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}">
                                @error('phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="biography" class="form-label fw-bold">Biography</label>
                            <textarea name="biography" id="biography" rows="6" class="form-control @error('biography') is-invalid @enderror">{{ old('biography') }}</textarea>
                            <div class="form-text">Separate paragraphs with new lines.</div>
                            @error('biography') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label fw-bold">Office Address</label>
                            <textarea name="address" id="address" rows="2" class="form-control @error('address') is-invalid @enderror">{{ old('address') }}</textarea>
                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <h5 class="mt-4 mb-3 border-bottom pb-2">Social Media Links</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="facebook_url" class="form-label small">Facebook URL</label>
                                <input type="url" name="facebook_url" id="facebook_url" class="form-control form-control-sm" value="{{ old('facebook_url') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="twitter_url" class="form-label small">Twitter (X) URL</label>
                                <input type="url" name="twitter_url" id="twitter_url" class="form-control form-control-sm" value="{{ old('twitter_url') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="linkedin_url" class="form-label small">LinkedIn URL</label>
                                <input type="url" name="linkedin_url" id="linkedin_url" class="form-control form-control-sm" value="{{ old('linkedin_url') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="instagram_url" class="form-label small">Instagram URL</label>
                                <input type="url" name="instagram_url" id="instagram_url" class="form-control form-control-sm" value="{{ old('instagram_url') }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Status</h6>
                                <div class="mb-3">
                                    <select name="is_active" id="status" class="form-select">
                                        <option value="active" {{ old('is_active') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('is_active') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="slug" class="form-label small text-muted">Slug (Optional)</label>
                                    <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" placeholder="Auto-generated if empty">
                                </div>
                            </div>
                        </div>

                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Profile Photo</h6>
                                <input type="file" name="image" id="image" class="form-control mb-2" accept="image/*">
                                <div class="form-text small">Upload a professional photo.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-4">
                    <a href="{{ route('admin.personnel.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">Save Personnel</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
