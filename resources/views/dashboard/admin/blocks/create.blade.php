@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark">Add New Block</h1>
        <a href="{{ route('admin.pages.blocks.index', $page->id) }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Back to Blocks
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.pages.blocks.store', $page->id) }}" method="POST" enctype="multipart/form-data" id="create-block-form">
                @csrf

                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <label for="type" class="form-label fw-bold">Block Type</label>
                        <input type="text" name="type" id="type" value="{{ old('type') }}" class="form-control" placeholder="template / system / services" required>
                    </div>
                    <div class="col-md-4">
                        <label for="identifier" class="form-label fw-bold">Identifier</label>
                        <input type="text" name="identifier" id="identifier" value="{{ old('identifier') }}" class="form-control" placeholder="about-page-first-section" required>
                        <small class="text-muted d-block mt-1">Examples: about-page-first-section, about-page-second-section, about-page-third-section, about-page-fourth-section</small>
                    </div>
                    <div class="col-md-4">
                        <label for="order" class="form-label fw-bold">Sort Order</label>
                        <input type="number" name="order" id="order" value="{{ old('order', 1) }}" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" checked>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>

                <hr class="my-4">
                <h5 class="fw-bold mb-3">Block Content</h5>

                <div id="university-management-page-first-section" class="identifier-section d-none">
                    <div class="card border mb-3">
                        <div class="card-header fw-bold">University Management Hero</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Main Heading <span class="text-danger">*</span></label>
                                <input type="text" name="content[heading1]" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Intro Paragraph</label>
                                <textarea name="content[content1]" class="form-control" rows="4"></textarea>
                                <small class="text-muted">Use new lines to create separate paragraphs.</small>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Hero Image Left URL</label>
                                    <input type="text" name="content[imageUrl1]" class="form-control" placeholder="https://...">
                                    <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                                    <input type="file" name="images[imageUrl1]" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Hero Image Right URL</label>
                                    <input type="text" name="content[imageUrl2]" class="form-control" placeholder="https://...">
                                    <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                                    <input type="file" name="images[imageUrl2]" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="management-leadership" class="identifier-section d-none">
                    <div class="card border mb-3">
                        <div class="card-header fw-bold">Leadership Team Section</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Heading</label>
                                <input type="text" name="content[heading]" class="form-control" placeholder="University Leadership">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Subheading</label>
                                <input type="text" name="content[subheading]" class="form-control" placeholder="Principal Officers">
                            </div>
                            <div class="mb-2 d-flex align-items-center justify-content-between">
                                <label class="form-label fw-bold mb-0">Additional Contents (Optional)</label>
                                <button type="button" class="btn btn-outline-secondary btn-sm add-row-btn">Add Item</button>
                            </div>
                            @include('dashboard.admin.blocks.partials.repeater', ['key' => 'additional_contents', 'value' => [], 'identifier' => 'management-leadership'])
                        </div>
                    </div>
                </div>

                <div id="management-other" class="identifier-section d-none">
                    <div class="card border mb-3">
                        <div class="card-header fw-bold">Other Management Section</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Heading</label>
                                <input type="text" name="content[heading]" class="form-control" placeholder="Management Team">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Subheading</label>
                                <input type="text" name="content[subheading]" class="form-control" placeholder="Heads of units and departments.">
                            </div>
                            <div class="mb-2 d-flex align-items-center justify-content-between">
                                <label class="form-label fw-bold mb-0">Additional Contents (Optional)</label>
                                <button type="button" class="btn btn-outline-secondary btn-sm add-row-btn">Add Item</button>
                            </div>
                            @include('dashboard.admin.blocks.partials.repeater', ['key' => 'additional_contents', 'value' => [], 'identifier' => 'management-other'])
                        </div>
                    </div>
                </div>

                <div id="admission-undergraduate" class="identifier-section d-none">
                    <div class="card border mb-3">
                        <div class="card-header fw-bold">Undergraduate Admissions</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Main Heading <span class="text-danger">*</span></label>
                                <input type="text" name="content[heading1]" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Intro Paragraph <span class="text-danger">*</span></label>
                                <textarea name="content[content1]" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Hero Image Left URL</label>
                                <input type="text" name="content[imageUrl1]" class="form-control" placeholder="https://...">
                                <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                                <input type="file" name="images[imageUrl1]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Hero Image Right URL</label>
                                <input type="text" name="content[imageUrl2]" class="form-control" placeholder="https://...">
                                <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                                <input type="file" name="images[imageUrl2]" class="form-control">
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 2 Heading</label>
                                <input type="text" name="content[heading2]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 2 Description</label>
                                <textarea name="content[content2]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Section 2 List Type</label>
                                    <select name="content[content2_list_type]" class="form-select">
                                        <option value="">None</option>
                                        <option value="bulleted">Bulleted (UL)</option>
                                        <option value="numbered">Numbered (OL)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Section 2 List Items</label>
                                    <div class="repeater-container" data-key="content2_list_items" data-schema="simple">
                                        <div class="repeater-items">
                                            <div class="empty-message text-muted small">No list items added yet</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 3 Heading</label>
                                <input type="text" name="content[heading3]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 3 Description</label>
                                <textarea name="content[content3]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Apply Now Link</label>
                                <input type="text" name="content[link1]" class="form-control" placeholder="https://admission.veritas.edu.ng/...">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 4 Heading</label>
                                <input type="text" name="content[heading4]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 4 Description</label>
                                <textarea name="content[content4]" class="form-control" rows="3"></textarea>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 5 Heading</label>
                                <input type="text" name="content[heading5]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 5 Description</label>
                                <textarea name="content[content5]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 6 Heading</label>
                                <input type="text" name="content[heading6]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 6 Description</label>
                                <textarea name="content[content6]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 7 Heading</label>
                                <input type="text" name="content[heading7]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 7 Description</label>
                                <textarea name="content[content7]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 8 Heading</label>
                                <input type="text" name="content[heading8]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 8 Description</label>
                                <textarea name="content[content8]" class="form-control" rows="3"></textarea>
                            </div>
                            <hr>
                            <div class="mb-2 d-flex align-items-center justify-content-between">
                                <label class="form-label fw-bold mb-0">Contact List</label>
                                <button type="button" class="btn btn-outline-secondary btn-sm add-row-btn">Add Contact</button>
                            </div>
                            <div class="repeater-container" data-key="list" data-schema="object" data-keys='["name","phone","email"]'>
                                <div class="repeater-items">
                                    <div class="empty-message text-muted small">No contacts added yet</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="admission-jupeb" class="identifier-section d-none">
                    <div class="card border mb-3">
                        <div class="card-header fw-bold">JUPEB Admissions</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Main Heading <span class="text-danger">*</span></label>
                                <input type="text" name="content[heading1]" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Intro Paragraph <span class="text-danger">*</span></label>
                                <textarea name="content[content1]" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Hero Image Left URL</label>
                                <input type="text" name="content[imageUrl1]" class="form-control" placeholder="https://...">
                                <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                                <input type="file" name="images[imageUrl1]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Hero Image Right URL</label>
                                <input type="text" name="content[imageUrl2]" class="form-control" placeholder="https://...">
                                <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                                <input type="file" name="images[imageUrl2]" class="form-control">
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 2 Heading</label>
                                <input type="text" name="content[heading2]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 2 Description</label>
                                <textarea name="content[content2]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Section 2 List Type</label>
                                    <select name="content[content2_list_type]" class="form-select">
                                        <option value="">None</option>
                                        <option value="bulleted">Bulleted (UL)</option>
                                        <option value="numbered">Numbered (OL)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Section 2 List Items</label>
                                    <div class="repeater-container" data-key="content2_list_items" data-schema="simple">
                                        <div class="repeater-items">
                                            <div class="empty-message text-muted small">No list items added yet</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 3 Heading</label>
                                <input type="text" name="content[heading3]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 3 Description</label>
                                <textarea name="content[content3]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Apply Now Link</label>
                                <input type="text" name="content[link1]" class="form-control" placeholder="https://admission.veritas.edu.ng/...">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 4 Heading</label>
                                <input type="text" name="content[heading4]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 4 Description</label>
                                <textarea name="content[content4]" class="form-control" rows="3"></textarea>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 5 Heading</label>
                                <input type="text" name="content[heading5]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 5 Description</label>
                                <textarea name="content[content5]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 6 Heading</label>
                                <input type="text" name="content[heading6]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 6 Description</label>
                                <textarea name="content[content6]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 7 Heading</label>
                                <input type="text" name="content[heading7]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 7 Description</label>
                                <textarea name="content[content7]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 8 Heading</label>
                                <input type="text" name="content[heading8]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 8 Description</label>
                                <textarea name="content[content8]" class="form-control" rows="3"></textarea>
                            </div>
                            <hr>
                            <div class="mb-2 d-flex align-items-center justify-content-between">
                                <label class="form-label fw-bold mb-0">Contact List</label>
                                <button type="button" class="btn btn-outline-secondary btn-sm add-row-btn">Add Contact</button>
                            </div>
                            <div class="repeater-container" data-key="list" data-schema="object" data-keys='["name","phone","email"]'>
                                <div class="repeater-items">
                                    <div class="empty-message text-muted small">No contacts added yet</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="admission-ijamb" class="identifier-section d-none">
                    <div class="card border mb-3">
                        <div class="card-header fw-bold">IJAMB Admissions</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Main Heading <span class="text-danger">*</span></label>
                                <input type="text" name="content[heading1]" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Intro Paragraph <span class="text-danger">*</span></label>
                                <textarea name="content[content1]" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Hero Image Left URL</label>
                                <input type="text" name="content[imageUrl1]" class="form-control" placeholder="https://...">
                                <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                                <input type="file" name="images[imageUrl1]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Hero Image Right URL</label>
                                <input type="text" name="content[imageUrl2]" class="form-control" placeholder="https://...">
                                <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                                <input type="file" name="images[imageUrl2]" class="form-control">
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 2 Heading</label>
                                <input type="text" name="content[heading2]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 2 Description</label>
                                <textarea name="content[content2]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Section 2 List Type</label>
                                    <select name="content[content2_list_type]" class="form-select">
                                        <option value="">None</option>
                                        <option value="bulleted">Bulleted (UL)</option>
                                        <option value="numbered">Numbered (OL)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Section 2 List Items</label>
                                    <div class="repeater-container" data-key="content2_list_items" data-schema="simple">
                                        <div class="repeater-items">
                                            <div class="empty-message text-muted small">No list items added yet</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 3 Heading</label>
                                <input type="text" name="content[heading3]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 3 Description</label>
                                <textarea name="content[content3]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Apply Now Link</label>
                                <input type="text" name="content[link1]" class="form-control" placeholder="https://admission.veritas.edu.ng/...">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 4 Heading</label>
                                <input type="text" name="content[heading4]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 4 Description</label>
                                <textarea name="content[content4]" class="form-control" rows="3"></textarea>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 5 Heading</label>
                                <input type="text" name="content[heading5]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 5 Description</label>
                                <textarea name="content[content5]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 6 Heading</label>
                                <input type="text" name="content[heading6]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 6 Description</label>
                                <textarea name="content[content6]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 7 Heading</label>
                                <input type="text" name="content[heading7]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 7 Description</label>
                                <textarea name="content[content7]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 8 Heading</label>
                                <input type="text" name="content[heading8]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 8 Description</label>
                                <textarea name="content[content8]" class="form-control" rows="3"></textarea>
                            </div>
                            <hr>
                            <div class="mb-2 d-flex align-items-center justify-content-between">
                                <label class="form-label fw-bold mb-0">Contact List</label>
                                <button type="button" class="btn btn-outline-secondary btn-sm add-row-btn">Add Contact</button>
                            </div>
                            <div class="repeater-container" data-key="list" data-schema="object" data-keys='["name","phone","email"]'>
                                <div class="repeater-items">
                                    <div class="empty-message text-muted small">No contacts added yet</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="admission-sandwich" class="identifier-section d-none">
                    <div class="card border mb-3">
                        <div class="card-header fw-bold">Sandwich Admissions</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Main Heading <span class="text-danger">*</span></label>
                                <input type="text" name="content[heading1]" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Intro Paragraph <span class="text-danger">*</span></label>
                                <textarea name="content[content1]" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Hero Image Left URL</label>
                                <input type="text" name="content[imageUrl1]" class="form-control" placeholder="https://...">
                                <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                                <input type="file" name="images[imageUrl1]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Hero Image Right URL</label>
                                <input type="text" name="content[imageUrl2]" class="form-control" placeholder="https://...">
                                <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                                <input type="file" name="images[imageUrl2]" class="form-control">
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 2 Heading</label>
                                <input type="text" name="content[heading2]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 2 Description</label>
                                <textarea name="content[content2]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Section 2 List Type</label>
                                    <select name="content[content2_list_type]" class="form-select">
                                        <option value="">None</option>
                                        <option value="bulleted">Bulleted (UL)</option>
                                        <option value="numbered">Numbered (OL)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Section 2 List Items</label>
                                    <div class="repeater-container" data-key="content2_list_items" data-schema="simple">
                                        <div class="repeater-items">
                                            <div class="empty-message text-muted small">No list items added yet</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 3 Heading</label>
                                <input type="text" name="content[heading3]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 3 Description</label>
                                <textarea name="content[content3]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Apply Now Link</label>
                                <input type="text" name="content[link1]" class="form-control" placeholder="https://admission.veritas.edu.ng/...">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 4 Heading</label>
                                <input type="text" name="content[heading4]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 4 Description</label>
                                <textarea name="content[content4]" class="form-control" rows="3"></textarea>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 5 Heading</label>
                                <input type="text" name="content[heading5]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 5 Description</label>
                                <textarea name="content[content5]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 6 Heading</label>
                                <input type="text" name="content[heading6]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 6 Description</label>
                                <textarea name="content[content6]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 7 Heading</label>
                                <input type="text" name="content[heading7]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 7 Description</label>
                                <textarea name="content[content7]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 8 Heading</label>
                                <input type="text" name="content[heading8]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 8 Description</label>
                                <textarea name="content[content8]" class="form-control" rows="3"></textarea>
                            </div>
                            <hr>
                            <div class="mb-2 d-flex align-items-center justify-content-between">
                                <label class="form-label fw-bold mb-0">Contact List</label>
                                <button type="button" class="btn btn-outline-secondary btn-sm add-row-btn">Add Contact</button>
                            </div>
                            <div class="repeater-container" data-key="list" data-schema="object" data-keys='["name","phone","email"]'>
                                <div class="repeater-items">
                                    <div class="empty-message text-muted small">No contacts added yet</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="admission-postgraduate" class="identifier-section d-none">
                    <div class="card border mb-3">
                        <div class="card-header fw-bold">Postgraduate Admissions</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Main Heading <span class="text-danger">*</span></label>
                                <input type="text" name="content[heading1]" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Intro Paragraph <span class="text-danger">*</span></label>
                                <textarea name="content[content1]" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Hero Image Left URL</label>
                                <input type="text" name="content[imageUrl1]" class="form-control" placeholder="https://...">
                                <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                                <input type="file" name="images[imageUrl1]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Hero Image Right URL</label>
                                <input type="text" name="content[imageUrl2]" class="form-control" placeholder="https://...">
                                <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                                <input type="file" name="images[imageUrl2]" class="form-control">
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 2 Heading</label>
                                <input type="text" name="content[heading2]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 2 Description</label>
                                <textarea name="content[content2]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Section 2 List Type</label>
                                    <select name="content[content2_list_type]" class="form-select">
                                        <option value="">None</option>
                                        <option value="bulleted">Bulleted (UL)</option>
                                        <option value="numbered">Numbered (OL)</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Section 2 List Items</label>
                                    <div class="repeater-container" data-key="content2_list_items" data-schema="simple">
                                        <div class="repeater-items">
                                            <div class="empty-message text-muted small">No list items added yet</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 3 Heading</label>
                                <input type="text" name="content[heading3]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 3 Description</label>
                                <textarea name="content[content3]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Apply Now Link</label>
                                <input type="text" name="content[link1]" class="form-control" placeholder="https://admission.veritas.edu.ng/...">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 4 Heading</label>
                                <input type="text" name="content[heading4]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 4 Description</label>
                                <textarea name="content[content4]" class="form-control" rows="3"></textarea>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 5 Heading</label>
                                <input type="text" name="content[heading5]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 5 Description</label>
                                <textarea name="content[content5]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 6 Heading</label>
                                <input type="text" name="content[heading6]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 6 Description</label>
                                <textarea name="content[content6]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 7 Heading</label>
                                <input type="text" name="content[heading7]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 7 Description</label>
                                <textarea name="content[content7]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 8 Heading</label>
                                <input type="text" name="content[heading8]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section 8 Description</label>
                                <textarea name="content[content8]" class="form-control" rows="3"></textarea>
                            </div>
                            <hr>
                            <div class="mb-2 d-flex align-items-center justify-content-between">
                                <label class="form-label fw-bold mb-0">Contact List</label>
                                <button type="button" class="btn btn-outline-secondary btn-sm add-row-btn">Add Contact</button>
                            </div>
                            <div class="repeater-container" data-key="list" data-schema="object" data-keys='["name","phone","email"]'>
                                <div class="repeater-items">
                                    <div class="empty-message text-muted small">No contacts added yet</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="about-first" class="identifier-section d-none">
                    <div class="card border mb-3">
                        <div class="card-header fw-bold">Hero Section</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Main Heading <span class="text-danger">*</span></label>
                                <input type="text" name="content[heading1]" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Intro Paragraph <span class="text-danger">*</span></label>
                                <textarea name="content[content1]" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Secondary Paragraph</label>
                                <textarea name="content[content2]" class="form-control" rows="4"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Hero Image URL</label>
                                <input type="text" name="content[imageUrl1]" class="form-control" placeholder="https://...">
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted">Alt Text</label>
                                        <input type="text" name="content[imageUrl1_alt]" class="form-control form-control-sm" placeholder="Describe image">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted">Caption</label>
                                        <input type="text" name="content[imageUrl1_caption]" class="form-control form-control-sm" placeholder="Image caption">
                                    </div>
                                </div>
                                <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                                <input type="file" name="images[imageUrl1]" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div id="about-second" class="identifier-section d-none">
                    <div class="card border mb-3">
                        <div class="card-header fw-bold">Our Journey</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section Heading <span class="text-danger">*</span></label>
                                <input type="text" name="content[heading1]" class="form-control" required>
                            </div>
                            @for($i=1; $i<=5; $i++)
                            <div class="mb-3">
                                <label class="form-label fw-bold">Paragraph {{ $i }} @if($i===1)<span class="text-danger">*</span>@endif</label>
                                <textarea name="content[content{{ $i }}]" class="form-control" rows="3" @if($i===1) required @endif></textarea>
                            </div>
                            @endfor
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section Image URL</label>
                                <input type="text" name="content[imageUrl1]" class="form-control" placeholder="https://...">
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted">Alt Text</label>
                                        <input type="text" name="content[imageUrl1_alt]" class="form-control form-control-sm" placeholder="Describe image">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted">Caption</label>
                                        <input type="text" name="content[imageUrl1_caption]" class="form-control form-control-sm" placeholder="Image caption">
                                    </div>
                                </div>
                                <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                                <input type="file" name="images[imageUrl1]" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div id="about-third" class="identifier-section d-none">
                    <div class="card border mb-3">
                        <div class="card-header fw-bold">Foundation & History</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Foundation Title <span class="text-danger">*</span></label>
                                <input type="text" name="content[heading1]" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Foundation Description <span class="text-danger">*</span></label>
                                <textarea name="content[content1]" class="form-control" rows="3" required></textarea>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Mission Title</label>
                                <input type="text" name="content[heading2]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Mission Description</label>
                                <textarea name="content[content2]" class="form-control" rows="3"></textarea>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Vision Title</label>
                                <input type="text" name="content[heading3]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Vision Description</label>
                                <textarea name="content[content3]" class="form-control" rows="3"></textarea>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Philosophy Title</label>
                                <input type="text" name="content[heading4]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Philosophy Description</label>
                                <textarea name="content[content4]" class="form-control" rows="3"></textarea>
                            </div>
                            <hr>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Core Values</label>
                                <input type="text" name="content[heading5]" class="form-control" placeholder="Core Values">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Core Values Description</label>
                                <textarea name="content[content5_description]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-2 d-flex align-items-center justify-content-between">
                                <label class="form-label fw-bold mb-0">Core Values List</label>
                                <button type="button" class="btn btn-outline-secondary btn-sm add-row-btn">Add Value</button>
                            </div>
                            <div class="repeater-container" data-key="content5" data-schema="object" data-keys='["title","description"]'>
                                <div class="repeater-items">
                                    <div class="empty-message text-muted small">No values added yet</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="about-fourth" class="identifier-section d-none">
                    <div class="card border mb-3">
                        <div class="card-header fw-bold">Management Team Section</div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Section Heading <span class="text-danger">*</span></label>
                                <input type="text" name="content[heading1]" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Intro Paragraph <span class="text-danger">*</span></label>
                                <textarea name="content[content1]" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Secondary Paragraph</label>
                                <textarea name="content[content2]" class="form-control" rows="3"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Image URL</label>
                                <input type="text" name="content[imageUrl1]" class="form-control" placeholder="https://...">
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted">Alt Text</label>
                                        <input type="text" name="content[imageUrl1_alt]" class="form-control form-control-sm" placeholder="Describe image">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small text-muted">Caption</label>
                                        <input type="text" name="content[imageUrl1_caption]" class="form-control form-control-sm" placeholder="Image caption">
                                    </div>
                                </div>
                                <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                                <input type="file" name="images[imageUrl1]" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Button Text <span class="text-danger">*</span></label>
                                <input type="text" name="content[buttonText]" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Button Link (URL) <span class="text-danger">*</span></label>
                                <input type="text" name="content[buttonLink]" class="form-control" placeholder="/university-management" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="generic-section">
                    <div class="alert alert-info">
                        For non-About blocks or advanced structures, use the Raw JSON editor below or submit generic fields.
                    </div>
                </div>

                <div class="mb-4 mt-3">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-toggle="collapse" data-bs-target="#rawJsonCollapse">
                        <i class="fa-solid fa-code me-1"></i> Toggle Raw JSON Editor (Advanced)
                    </button>
                    <div class="collapse mt-3" id="rawJsonCollapse">
                        <div class="card card-body bg-light">
                            <label for="content_json" class="form-label fw-bold">Raw JSON Content</label>
                            <p class="text-muted small mb-2">Use this to add new fields or edit complex structures.</p>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" name="use_json" id="use_json" value="1">
                                <label class="form-check-label" for="use_json">
                                    <strong>Overwrite</strong> block content with this JSON
                                </label>
                            </div>
                            <textarea name="content_json" id="content_json" rows="10" class="form-control font-monospace">{}</textarea>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-plus me-2"></i>Create Block
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const idInput = document.getElementById('identifier');
        const sections = {
            'about-page-first-section': 'about-first',
            'about-page-second-section': 'about-second',
            'about-page-third-section': 'about-third',
            'about-page-fourth-section': 'about-fourth',
            'admission-undergraduate-page': 'admission-undergraduate',
            'admission-jupeb-page': 'admission-jupeb',
            'admission-ijamb-page': 'admission-ijamb',
            'admission-sandwich-page': 'admission-sandwich',
            'admission-postgraduate-page': 'admission-postgraduate',
        };
        const toggleSections = () => {
            const val = (idInput.value || '').trim();
            const target = sections[val];
            document.querySelectorAll('.identifier-section').forEach(el => el.classList.add('d-none'));
            if (target) {
                document.getElementById('generic-section').classList.add('d-none');
                document.getElementById(target).classList.remove('d-none');
            } else {
                document.getElementById('generic-section').classList.remove('d-none');
            }
        };
        idInput.addEventListener('input', toggleSections);
        toggleSections();

        document.body.addEventListener('click', function(e) {
            if (e.target.closest('.add-row-btn')) {
                const btn = e.target.closest('.add-row-btn');
                const container = btn.closest('.repeater-container');
                const itemsContainer = container.querySelector('.repeater-items');
                const key = container.dataset.key;
                const schema = container.dataset.schema;
                const keys = JSON.parse(container.dataset.keys);
                const index = new Date().getTime();
                let html = `
                    <div class="repeater-item card mb-2 p-2 bg-white border shadow-sm">
                        <div class="d-flex justify-content-end mb-1">
                            <button type="button" class="btn btn-outline-danger btn-sm remove-row-btn" style="padding: 0px 5px; font-size: 0.7rem;" title="Remove Item">
                                <i class="fa-solid fa-times"></i>
                            </button>
                        </div>
                        <div class="row g-2">
                `;
                if (schema === 'simple') {
                    html += `
                        <div class="col-12">
                            <input type="text" name="content[${key}][${index}]" class="form-control form-control-sm" placeholder="Value">
                        </div>
                    `;
                } else {
                    keys.forEach(field => {
                        let label = field.replace(/_/g, ' ');
                        label = label.replace(/\b\w/g, l => l.toUpperCase());
                        let input = '';
                        if(field.includes('image') || field.includes('img') || field.includes('src')) {
                            input = `
                                <div class="mb-1">
                                   <input type="text" name="content[${key}][${index}][${field}]" class="form-control form-control-sm mb-1" placeholder="Image URL">
                                   <input type="file" name="files[${key}][${index}][${field}]" class="form-control form-control-sm">
                                   <small class="text-muted" style="font-size: 0.65rem;">Upload new file to replace URL</small>
                                </div>
                            `;
                        } else {
                            input = `<input type="text" name="content[${key}][${index}][${field}]" class="form-control form-control-sm">`;
                        }
                        html += `
                            <div class="col-md-6">
                                <label class="form-label small text-muted text-capitalize mb-0" style="font-size: 0.7rem;">${label}</label>
                                ${input}
                            </div>
                        `;
                    });
                }
                html += `</div></div>`;
                const emptyMsg = itemsContainer.querySelector('.empty-message');
                if(emptyMsg) emptyMsg.remove();
                itemsContainer.insertAdjacentHTML('beforeend', html);
            }
            if (e.target.closest('.remove-row-btn')) {
                const btn = e.target.closest('.remove-row-btn');
                const item = btn.closest('.repeater-item');
                item.remove();
            }
        });
    });
</script>
 
@endsection
