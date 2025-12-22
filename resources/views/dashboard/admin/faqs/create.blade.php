@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark">Add FAQ</h1>
        <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Back to List
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.faqs.store') }}" method="POST">
                @csrf

                <div class="row g-4 mb-4">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="question" class="form-label fw-bold">Question <span class="text-danger">*</span></label>
                            <input type="text" name="question" id="question" class="form-control @error('question') is-invalid @enderror" value="{{ old('question') }}" required>
                            @error('question') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="answer" class="form-label fw-bold">Answer <span class="text-danger">*</span></label>
                            <textarea name="answer" id="answer" rows="6" class="form-control @error('answer') is-invalid @enderror" required>{{ old('answer') }}</textarea>
                            @error('answer') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-light border-0 mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Settings</h6>
                                
                                <div class="mb-3">
                                    <label for="category" class="form-label fw-bold">Category</label>
                                    <input type="text" name="category" id="category" class="form-control @error('category') is-invalid @enderror" value="{{ old('category') }}" placeholder="e.g. General, Admissions">
                                    @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="order" class="form-label fw-bold">Display Order</label>
                                    <input type="number" name="order" id="order" class="form-control @error('order') is-invalid @enderror" value="{{ old('order', 0) }}">
                                    <div class="form-text small">Lower numbers appear first.</div>
                                    @error('order') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label fw-bold">Status</label>
                                    <select name="is_active" id="status" class="form-select">
                                        <option value="active" {{ old('is_active') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('is_active') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-4">
                    <a href="{{ route('admin.faqs.index') }}" class="btn btn-light">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">Save FAQ</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
