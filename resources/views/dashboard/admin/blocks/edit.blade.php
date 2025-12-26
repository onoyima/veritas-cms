@extends('layouts.staff')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-dark">Edit Block</h1>
        <a href="{{ route('admin.pages.blocks.index', $block->page_id) }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left me-2"></i>Back to Blocks
        </a>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.blocks.update', $block->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label for="type" class="form-label fw-bold">Block Type</label>
                        <input type="text" name="type" id="type" value="{{ old('type', $block->type) }}" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label for="identifier" class="form-label fw-bold">Identifier (Optional)</label>
                        <input type="text" name="identifier" id="identifier" value="{{ old('identifier', $block->identifier) }}" class="form-control">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="order" class="form-label fw-bold">Sort Order</label>
                    <input type="number" name="order" id="order" value="{{ old('order', $block->order) }}" class="form-control">
                </div>

                <hr class="my-4">

                <h5 class="fw-bold mb-3">Block Content</h5>
                <div id="content-fields">
                    @php
                        $content = $block->content ?? [];
                        if (is_string($content)) {
                            $content = json_decode($content, true) ?? [];
                        }
                        // Helper: flatten rich-text document arrays into plain text for admin-friendly editing
                        function flatten_rich_text($val): string {
                            if (is_string($val)) return $val;
                            if (!is_array($val)) return '';
                            $texts = [];
                            $stack = [$val];
                            while ($stack) {
                                $node = array_pop($stack);
                                if (is_array($node)) {
                                    if (isset($node['nodeType']) && $node['nodeType'] === 'text' && isset($node['value'])) {
                                        $texts[] = $node['value'];
                                    }
                                    if (isset($node['content']) && is_array($node['content'])) {
                                        foreach ($node['content'] as $child) {
                                            $stack[] = $child;
                                        }
                                    }
                                }
                            }
                            return trim(implode("\n\n", $texts));
                        }
                        // Ensure required keys exist for known identifiers
                        $fieldHelp = [];
                        $requiredKeys = [];
                        switch ($block->identifier) {
                        case 'admission-undergraduate-page':
                        case 'admission-jupeb-page':
                        case 'admission-ijamb-page':
                        case 'admission-sandwich-page':
                        case 'admission-postgraduate-page':
                            $content['heading1'] = $content['heading1'] ?? '';
                            $content['content1'] = $content['content1'] ?? '';
                            $content['imageUrl1'] = $content['imageUrl1'] ?? '';
                            $content['imageUrl2'] = $content['imageUrl2'] ?? '';
                            $content['heading2'] = $content['heading2'] ?? '';
                            $content['content2'] = $content['content2'] ?? '';
                            $content['heading3'] = $content['heading3'] ?? '';
                            $content['content3'] = $content['content3'] ?? '';
                            $content['link1'] = $content['link1'] ?? '';
                            $content['heading4'] = $content['heading4'] ?? '';
                            $content['content4'] = $content['content4'] ?? '';
                            $content['heading5'] = $content['heading5'] ?? '';
                            $content['content5'] = $content['content5'] ?? '';
                            $content['heading6'] = $content['heading6'] ?? '';
                            $content['content6'] = $content['content6'] ?? '';
                            $content['heading7'] = $content['heading7'] ?? '';
                            $content['content7'] = $content['content7'] ?? '';
                            $content['heading8'] = $content['heading8'] ?? '';
                            $content['content8'] = $content['content8'] ?? '';
                            $content['list'] = is_array($content['list'] ?? null) ? $content['list'] : [];
                            // Derive Section 2 list editor defaults if content2 is a document list
                            $content['content2_list_type'] = $content['content2_list_type'] ?? '';
                            $content['content2_list_items'] = is_array($content['content2_list_items'] ?? null) ? $content['content2_list_items'] : [];
                            if (is_array($content['content2'] ?? null) && isset($content['content2']['nodeType']) && $content['content2']['nodeType'] === 'document') {
                                $doc = $content['content2'];
                                $listNode = null;
                                foreach (($doc['content'] ?? []) as $node) {
                                    if (is_array($node) && isset($node['nodeType']) && in_array($node['nodeType'], ['unordered-list', 'ordered-list'])) {
                                        $listNode = $node;
                                        break;
                                    }
                                }
                                if ($listNode) {
                                    $content['content2_list_type'] = $listNode['nodeType'] === 'ordered-list' ? 'numbered' : 'bulleted';
                                    $items = [];
                                    foreach (($listNode['content'] ?? []) as $li) {
                                        if (isset($li['content'][0]['content'][0]['value'])) {
                                            $items[] = $li['content'][0]['content'][0]['value'];
                                        }
                                    }
                                    $content['content2_list_items'] = $items;
                                }
                            }
                            $fieldHelp = [
                                'heading1' => 'Main section heading',
                                'content1' => 'Intro paragraph under the hero',
                                'imageUrl1' => 'Hero image left URL',
                                'imageUrl2' => 'Hero image right URL',
                                'heading2' => 'Section heading (e.g., Admission Requirements)',
                                'content2' => 'Description under heading 2',
                                'content2_list_type' => 'Choose list type for Section 2',
                                'content2_list_items' => 'Add list items for Section 2',
                                'heading3' => 'Section heading (e.g., How to Apply)',
                                'content3' => 'Description under heading 3',
                                'link1' => 'Apply Now link URL',
                                'heading4' => 'Section heading (e.g., Tuition & Fees / Duration / Benefits)',
                                'content4' => 'Description under heading 4',
                                'heading5' => 'Optional section heading',
                                'content5' => 'Optional section description',
                                'heading6' => 'Optional section heading',
                                'content6' => 'Optional section description',
                                'heading7' => 'Optional section heading',
                                'content7' => 'Optional section description',
                                'heading8' => 'Optional section heading',
                                'content8' => 'Optional section description',
                                'list' => 'Contact list items. Each item will be Name === Phone === Email',
                            ];
                            $requiredKeys = ['heading1', 'content1', 'imageUrl1', 'imageUrl2'];
                            break;
                        case 'home-discover':
                            $content['heading'] = $content['heading'] ?? '';
                            $content['subheading'] = $content['subheading'] ?? '';
                            $content['items'] = is_array($content['items'] ?? null) ? $content['items'] : [];
                            break;
                        case 'home-services':
                            $content['heading'] = $content['heading'] ?? '';
                            $content['subheading'] = $content['subheading'] ?? '';
                            $content['items'] = is_array($content['items'] ?? null) ? $content['items'] : [];
                            break;
                        case 'home-admissions':
                            $content['heading'] = $content['heading'] ?? '';
                            $content['subheading'] = $content['subheading'] ?? '';
                            $content['apply_link'] = $content['apply_link'] ?? '';
                            $content['items'] = is_array($content['items'] ?? null) ? $content['items'] : [];
                            break;
                        case 'home-page-first-section':
                            $content['heading1'] = $content['heading1'] ?? '';
                            $content['content1'] = $content['content1'] ?? '';
                            $content['list'] = is_array($content['list'] ?? null) ? $content['list'] : [];
                            $content['stats'] = is_array($content['stats'] ?? null) ? $content['stats'] : [];
                            $content['quick_links'] = is_array($content['quick_links'] ?? null) ? $content['quick_links'] : [];
                            break;
                        case 'home-page-third-section':
                            $content['heading1'] = $content['heading1'] ?? '';
                            $content['content1'] = $content['content1'] ?? '';
                            $content['imageUrl1'] = $content['imageUrl1'] ?? '';
                            $content['heading2'] = $content['heading2'] ?? '';
                            $content['content2'] = $content['content2'] ?? '';
                            $content['heading3'] = $content['heading3'] ?? '';
                            $content['content3'] = $content['content3'] ?? '';
                            $content['heading4'] = $content['heading4'] ?? '';
                            $content['content4'] = $content['content4'] ?? '';
                            break;
                        case 'home-page-seventh-section':
                            $content['heading'] = $content['heading'] ?? '';
                            $content['subheading'] = $content['subheading'] ?? '';
                            $content['imageUrl1'] = $content['imageUrl1'] ?? '';
                            $content['heading1'] = $content['heading1'] ?? '';
                            $content['content1'] = $content['content1'] ?? '';
                            $content['heading2'] = $content['heading2'] ?? '';
                            $content['content2'] = $content['content2'] ?? '';
                            $content['heading3'] = $content['heading3'] ?? '';
                            $content['content3'] = $content['content3'] ?? '';
                            $content['heading4'] = $content['heading4'] ?? '';
                            $content['content4'] = $content['content4'] ?? '';
                            $content['heading5'] = $content['heading5'] ?? '';
                            $content['content5'] = $content['content5'] ?? '';
                            $content['heading6'] = $content['heading6'] ?? '';
                            $content['content6'] = $content['content6'] ?? '';
                            // Help and required
                            $fieldHelp = [
                                'heading' => 'Short label above the section',
                                'subheading' => 'Large title of the section',
                                'imageUrl1' => 'Video or image URL (Cloudinary mp4 or YouTube embed/watch/short)',
                                'heading1' => 'Stat 1 value (number)',
                                'content1' => 'Stat 1 label',
                                'heading2' => 'Stat 2 value (number)',
                                'content2' => 'Stat 2 label',
                                'heading3' => 'Stat 3 value (number or currency)',
                                'content3' => 'Stat 3 label',
                                'heading4' => 'Stat 4 value',
                                'content4' => 'Stat 4 label',
                                'heading5' => 'Stat 5 value',
                                'content5' => 'Stat 5 label',
                                'heading6' => 'Stat 6 value',
                                'content6' => 'Stat 6 label',
                            ];
                            $requiredKeys = ['subheading'];
                            break;
                        case 'home-map':
                            $content['iframe_url'] = $content['iframe_url'] ?? '';
                            $content['address'] = $content['address'] ?? '';
                            $content['email'] = $content['email'] ?? '';
                            $content['phone_link'] = $content['phone_link'] ?? '';
                            $content['phone'] = $content['phone'] ?? '';
                            break;
                        case 'about-page-first-section':
                            $content['heading1'] = $content['heading1'] ?? '';
                            $content['content1'] = $content['content1'] ?? '';
                            $content['content2'] = $content['content2'] ?? '';
                            $content['imageUrl1'] = $content['imageUrl1'] ?? '';
                            $fieldHelp = [
                                'heading1' => 'Main heading for the hero section',
                                'content1' => 'Intro paragraph',
                                'content2' => 'Secondary paragraph (optional)',
                                'imageUrl1' => 'Hero image URL (or video URL if applicable)',
                            ];
                            $requiredKeys = ['heading1', 'content1'];
                            break;
                        case 'about-page-second-section':
                            $content['heading1'] = $content['heading1'] ?? '';
                            $content['content1'] = $content['content1'] ?? '';
                            $content['content2'] = $content['content2'] ?? '';
                            $content['content3'] = $content['content3'] ?? '';
                            $content['content4'] = $content['content4'] ?? '';
                            $content['content5'] = $content['content5'] ?? '';
                            $content['imageUrl1'] = $content['imageUrl1'] ?? '';
                            $fieldHelp = [
                                'heading1' => 'Section heading (Our Journey)',
                                'content1' => 'Paragraph 1',
                                'content2' => 'Paragraph 2',
                                'content3' => 'Paragraph 3',
                                'content4' => 'Paragraph 4',
                                'content5' => 'Paragraph 5',
                                'imageUrl1' => 'Section image URL',
                            ];
                            $requiredKeys = ['heading1', 'content1'];
                            break;
                        case 'about-page-third-section':
                            $content['heading1'] = $content['heading1'] ?? '';
                            $content['content1'] = $content['content1'] ?? '';
                            $content['heading2'] = $content['heading2'] ?? '';
                            $content['content2'] = $content['content2'] ?? '';
                            $content['heading3'] = $content['heading3'] ?? '';
                            $content['content3'] = $content['content3'] ?? '';
                            $content['heading4'] = $content['heading4'] ?? '';
                            $content['content4'] = $content['content4'] ?? '';
                            $content['heading5'] = $content['heading5'] ?? '';
                            $content['content5_description'] = $content['content5_description'] ?? '';
                            $content['content5'] = is_array($content['content5'] ?? null) ? $content['content5'] : [];
                            $fieldHelp = [
                                'heading1' => 'Foundation title',
                                'content1' => 'Foundation description',
                                'heading2' => 'Mission title',
                                'content2' => 'Mission description',
                                'heading3' => 'Vision title',
                                'content3' => 'Vision description',
                                'heading4' => 'Philosophy title',
                                'content4' => 'Philosophy description',
                                'heading5' => 'Core Values title',
                                'content5_description' => 'Core Values intro paragraph above the list',
                                'content5' => 'Core Values list (each item is one value)',
                            ];
                            $requiredKeys = ['heading1', 'content1'];
                            break;
                        case 'about-page-fourth-section':
                            $content['heading1'] = $content['heading1'] ?? '';
                            $content['content1'] = $content['content1'] ?? '';
                            $content['content2'] = $content['content2'] ?? '';
                            $content['imageUrl1'] = $content['imageUrl1'] ?? '';
                            $content['buttonText'] = $content['buttonText'] ?? '';
                            $content['buttonLink'] = $content['buttonLink'] ?? '';
                            $fieldHelp = [
                                'heading1' => 'Management section heading',
                                'content1' => 'Intro paragraph',
                                'content2' => 'Secondary paragraph',
                                'imageUrl1' => 'Image URL for management section',
                                'buttonText' => 'CTA button text',
                                'buttonLink' => 'CTA target URL',
                            ];
                            $requiredKeys = ['heading1', 'content1', 'buttonText', 'buttonLink'];
                            break;
                    }
                @endphp

                    @php
                        $aboutIdentifiers = ['about-page-first-section','about-page-second-section','about-page-third-section','about-page-fourth-section'];
                    @endphp

                    @php
                        $admissionIdentifiers = ['admission-undergraduate-page','admission-jupeb-page','admission-ijamb-page','admission-sandwich-page','admission-postgraduate-page'];
                    @endphp

                    @if(in_array($block->identifier, $aboutIdentifiers))
                        @switch($block->identifier)
                            @case('about-page-first-section')
                                <div class="card border mb-3">
                                    <div class="card-header fw-bold">Hero Section</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Main Heading <span class="text-danger">*</span></label>
                                            <input type="text" name="content[heading1]" value="{{ flatten_rich_text($content['heading1'] ?? '') }}" class="form-control" required>
                                            <small class="text-muted">Example: About Veritas University</small>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Intro Paragraph <span class="text-danger">*</span></label>
                                            <textarea name="content[content1]" class="form-control" rows="4" required>{{ flatten_rich_text($content['content1'] ?? '') }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Secondary Paragraph</label>
                                            <textarea name="content[content2]" class="form-control" rows="4">{{ flatten_rich_text($content['content2'] ?? '') }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Hero Image URL</label>
                                            <input type="text" name="content[imageUrl1]" value="{{ is_array($content['imageUrl1'] ?? null) ? '' : ($content['imageUrl1'] ?? '') }}" class="form-control" placeholder="https://...">
                                            <div class="row mt-2">
                                                <div class="col-md-6">
                                                    <label class="form-label small text-muted">Alt Text</label>
                                                    <input type="text" name="content[imageUrl1_alt]" value="{{ $content['imageUrl1_alt'] ?? '' }}" class="form-control form-control-sm" placeholder="Describe image">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small text-muted">Caption</label>
                                                    <input type="text" name="content[imageUrl1_caption]" value="{{ $content['imageUrl1_caption'] ?? '' }}" class="form-control form-control-sm" placeholder="Image caption">
                                                </div>
                                            </div>
                                            <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                                            <input type="file" name="images[imageUrl1]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            @break
                            @case('about-page-second-section')
                                <div class="card border mb-3">
                                    <div class="card-header fw-bold">Our Journey</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Section Heading <span class="text-danger">*</span></label>
                                            <input type="text" name="content[heading1]" value="{{ flatten_rich_text($content['heading1'] ?? '') }}" class="form-control" required>
                                        </div>
                                        @foreach([1,2,3,4,5] as $i)
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Paragraph {{ $i }} @if($i===1)<span class="text-danger">*</span>@endif</label>
                                                <textarea name="content[content{{ $i }}]" class="form-control" rows="3" @if($i===1) required @endif>{{ flatten_rich_text($content['content'.$i] ?? '') }}</textarea>
                                            </div>
                                        @endforeach
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Section Image URL</label>
                                            <input type="text" name="content[imageUrl1]" value="{{ is_array($content['imageUrl1'] ?? null) ? '' : ($content['imageUrl1'] ?? '') }}" class="form-control" placeholder="https://...">
                                            <div class="row mt-2">
                                                <div class="col-md-6">
                                                    <label class="form-label small text-muted">Alt Text</label>
                                                    <input type="text" name="content[imageUrl1_alt]" value="{{ $content['imageUrl1_alt'] ?? '' }}" class="form-control form-control-sm" placeholder="Describe image">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small text-muted">Caption</label>
                                                    <input type="text" name="content[imageUrl1_caption]" value="{{ $content['imageUrl1_caption'] ?? '' }}" class="form-control form-control-sm" placeholder="Image caption">
                                                </div>
                                            </div>
                                            <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                                            <input type="file" name="images[imageUrl1]" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            @break
                            @case('about-page-third-section')
                                <div class="card border mb-3">
                                    <div class="card-header fw-bold">Foundation & History</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Foundation Title <span class="text-danger">*</span></label>
                                            <input type="text" name="content[heading1]" value="{{ flatten_rich_text($content['heading1'] ?? '') }}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Foundation Description <span class="text-danger">*</span></label>
                                            <textarea name="content[content1]" class="form-control" rows="3" required>{{ flatten_rich_text($content['content1'] ?? '') }}</textarea>
                                        </div>
                                        <hr>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Mission Title</label>
                                            <input type="text" name="content[heading2]" value="{{ flatten_rich_text($content['heading2'] ?? '') }}" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Mission Description</label>
                                            <textarea name="content[content2]" class="form-control" rows="3">{{ flatten_rich_text($content['content2'] ?? '') }}</textarea>
                                        </div>
                                        <hr>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Vision Title</label>
                                            <input type="text" name="content[heading3]" value="{{ flatten_rich_text($content['heading3'] ?? '') }}" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Vision Description</label>
                                            <textarea name="content[content3]" class="form-control" rows="3">{{ flatten_rich_text($content['content3'] ?? '') }}</textarea>
                                        </div>
                                        <hr>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Philosophy Title</label>
                                            <input type="text" name="content[heading4]" value="{{ flatten_rich_text($content['heading4'] ?? '') }}" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Philosophy Description</label>
                                            <textarea name="content[content4]" class="form-control" rows="3">{{ flatten_rich_text($content['content4'] ?? '') }}</textarea>
                                        </div>
                                        <hr>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Core Values</label>
                                            <input type="text" name="content[heading5]" value="{{ flatten_rich_text($content['heading5'] ?? '') }}" class="form-control" placeholder="Core Values">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Core Values Description</label>
                                            <textarea name="content[content5_description]" class="form-control" rows="3">{{ flatten_rich_text($content['content5_description'] ?? '') }}</textarea>
                                            @if(isset($fieldHelp['content5_description'])) <small class="text-muted d-block mt-1">{{ $fieldHelp['content5_description'] }}</small> @endif
                                        </div>
                                        <div class="mb-2 d-flex align-items-center justify-content-between">
                                            <label class="form-label fw-bold mb-0">Core Values List</label>
                                            <button type="button" class="btn btn-outline-secondary btn-sm add-row-btn">Add Value</button>
                                        </div>
                                        @include('dashboard.admin.blocks.partials.repeater', ['key' => 'content5', 'value' => is_array($content['content5'] ?? null) ? $content['content5'] : [], 'identifier' => $block->identifier])
                                    </div>
                                </div>
                            @break
                            @case('about-page-fourth-section')
                                <div class="card border mb-3">
                                    <div class="card-header fw-bold">Management Team Section</div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Section Heading <span class="text-danger">*</span></label>
                                            <input type="text" name="content[heading1]" value="{{ flatten_rich_text($content['heading1'] ?? '') }}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Intro Paragraph <span class="text-danger">*</span></label>
                                            <textarea name="content[content1]" class="form-control" rows="3" required>{{ flatten_rich_text($content['content1'] ?? '') }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Secondary Paragraph</label>
                                            <textarea name="content[content2]" class="form-control" rows="3">{{ flatten_rich_text($content['content2'] ?? '') }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Image URL</label>
                                            <input type="text" name="content[imageUrl1]" value="{{ is_array($content['imageUrl1'] ?? null) ? '' : ($content['imageUrl1'] ?? '') }}" class="form-control" placeholder="https://...">
                                            <div class="row mt-2">
                                                <div class="col-md-6">
                                                    <label class="form-label small text-muted">Alt Text</label>
                                                    <input type="text" name="content[imageUrl1_alt]" value="{{ $content['imageUrl1_alt'] ?? '' }}" class="form-control form-control-sm" placeholder="Describe image">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small text-muted">Caption</label>
                                                    <input type="text" name="content[imageUrl1_caption]" value="{{ $content['imageUrl1_caption'] ?? '' }}" class="form-control form-control-sm" placeholder="Image caption">
                                                </div>
                                            </div>
                                            <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                                            <input type="file" name="images[imageUrl1]" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Button Text <span class="text-danger">*</span></label>
                                            <input type="text" name="content[buttonText]" value="{{ flatten_rich_text($content['buttonText'] ?? '') }}" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Button Link (URL) <span class="text-danger">*</span></label>
                                            <input type="text" name="content[buttonLink]" value="{{ flatten_rich_text($content['buttonLink'] ?? '') }}" class="form-control" placeholder="/university-management" required>
                                        </div>
                                    </div>
                                </div>
                            @break
                        @endswitch
                    @elseif(in_array($block->identifier, $admissionIdentifiers))
                        <div class="card border mb-3">
                            <div class="card-header fw-bold text-capitalize">
                                {{ str_replace('-', ' ', str_replace('admission-', '', $block->identifier)) }} Section
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Main Heading <span class="text-danger">*</span></label>
                                    <input type="text" name="content[heading1]" value="{{ flatten_rich_text($content['heading1'] ?? '') }}" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Intro Paragraph <span class="text-danger">*</span></label>
                                    <textarea name="content[content1]" class="form-control" rows="4" required>{{ flatten_rich_text($content['content1'] ?? '') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Hero Image Left URL</label>
                                    <input type="text" name="content[imageUrl1]" value="{{ is_array($content['imageUrl1'] ?? null) ? '' : ($content['imageUrl1'] ?? '') }}" class="form-control" placeholder="https://...">
                                    <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                                    <input type="file" name="images[imageUrl1]" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Hero Image Right URL</label>
                                    <input type="text" name="content[imageUrl2]" value="{{ is_array($content['imageUrl2'] ?? null) ? '' : ($content['imageUrl2'] ?? '') }}" class="form-control" placeholder="https://...">
                                    <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                                    <input type="file" name="images[imageUrl2]" class="form-control">
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <div class="mb-2">
                                        <label class="form-label fw-bold mb-0">Section 2 Heading</label>
                                        <input type="text" name="content[heading2]" value="{{ flatten_rich_text($content['heading2'] ?? '') }}" class="form-control">
                                    </div>
                                    <label class="form-label fw-bold">Section 2 Description</label>
                                    <textarea name="content[content2]" class="form-control" rows="3">{{ flatten_rich_text($content['content2'] ?? '') }}</textarea>
                                    <div class="row mt-2">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Section 2 List Type</label>
                                            <select name="content[content2_list_type]" class="form-select">
                                                <option value="">None</option>
                                                <option value="bulleted" {{ ($content['content2_list_type'] ?? '') === 'bulleted' ? 'selected' : '' }}>Bulleted (UL)</option>
                                                <option value="numbered" {{ ($content['content2_list_type'] ?? '') === 'numbered' ? 'selected' : '' }}>Numbered (OL)</option>
                                            </select>
                                            @if(isset($fieldHelp['content2_list_type'])) <small class="text-muted d-block mt-1">{{ $fieldHelp['content2_list_type'] }}</small> @endif
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Section 2 List Items</label>
                                            @php
                                                $c2items = is_array($content['content2_list_items'] ?? null) ? $content['content2_list_items'] : [];
                                            @endphp
                                            @include('dashboard.admin.blocks.partials.repeater', ['key' => 'content2_list_items', 'value' => $c2items, 'identifier' => $block->identifier])
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="mb-2">
                                        <label class="form-label fw-bold mb-0">Section 3 Heading</label>
                                        <input type="text" name="content[heading3]" value="{{ flatten_rich_text($content['heading3'] ?? '') }}" class="form-control">
                                    </div>
                                    <label class="form-label fw-bold">Section 3 Description</label>
                                    <textarea name="content[content3]" class="form-control" rows="3">{{ flatten_rich_text($content['content3'] ?? '') }}</textarea>
                                    <small class="text-muted d-block mt-1">Apply Now link below</small>
                                    <input type="text" name="content[link1]" value="{{ flatten_rich_text($content['link1'] ?? '') }}" class="form-control" placeholder="https://admission.veritas.edu.ng/...">
                                </div>
                                <div class="mb-3">
                                    <div class="mb-2">
                                        <label class="form-label fw-bold mb-0">Section 4 Heading</label>
                                        <input type="text" name="content[heading4]" value="{{ flatten_rich_text($content['heading4'] ?? '') }}" class="form-control">
                                    </div>
                                    <label class="form-label fw-bold">Section 4 Description</label>
                                    <textarea name="content[content4]" class="form-control" rows="3">{{ flatten_rich_text($content['content4'] ?? '') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <div class="mb-2">
                                        <label class="form-label fw-bold mb-0">Section 5 Heading</label>
                                        <input type="text" name="content[heading5]" value="{{ flatten_rich_text($content['heading5'] ?? '') }}" class="form-control">
                                    </div>
                                    <label class="form-label fw-bold">Section 5 Description</label>
                                    <textarea name="content[content5]" class="form-control" rows="3">{{ flatten_rich_text($content['content5'] ?? '') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <div class="mb-2">
                                        <label class="form-label fw-bold mb-0">Section 6 Heading</label>
                                        <input type="text" name="content[heading6]" value="{{ flatten_rich_text($content['heading6'] ?? '') }}" class="form-control">
                                    </div>
                                    <label class="form-label fw-bold">Section 6 Description</label>
                                    <textarea name="content[content6]" class="form-control" rows="3">{{ flatten_rich_text($content['content6'] ?? '') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <div class="mb-2">
                                        <label class="form-label fw-bold mb-0">Section 7 Heading</label>
                                        <input type="text" name="content[heading7]" value="{{ flatten_rich_text($content['heading7'] ?? '') }}" class="form-control">
                                    </div>
                                    <label class="form-label fw-bold">Section 7 Description</label>
                                    <textarea name="content[content7]" class="form-control" rows="3">{{ flatten_rich_text($content['content7'] ?? '') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <div class="mb-2">
                                        <label class="form-label fw-bold mb-0">Section 8 Heading</label>
                                        <input type="text" name="content[heading8]" value="{{ flatten_rich_text($content['heading8'] ?? '') }}" class="form-control">
                                    </div>
                                    <label class="form-label fw-bold">Section 8 Description</label>
                                    <textarea name="content[content8]" class="form-control" rows="3">{{ flatten_rich_text($content['content8'] ?? '') }}</textarea>
                                </div>
                                <hr>
                                <div class="mb-2 d-flex align-items-center justify-content-between">
                                    <label class="form-label fw-bold mb-0">Contact List</label>
                                    <button type="button" class="btn btn-outline-secondary btn-sm add-row-btn">Add Contact</button>
                                </div>
                                @php
                                    $listVal = is_array($content['list'] ?? null) ? $content['list'] : [];
                                    // Normalize any "Name === Phone === Email" strings to objects for editing
                                    $listVal = array_map(function($item) {
                                        if (is_string($item) && str_contains($item, '===')) {
                                            $parts = array_map('trim', explode('===', $item));
                                            return ['name' => $parts[0] ?? '', 'phone' => $parts[1] ?? '', 'email' => $parts[2] ?? ''];
                                        }
                                        return $item;
                                    }, $listVal);
                                @endphp
                                @include('dashboard.admin.blocks.partials.repeater', [
                                    'key' => 'list',
                                    'value' => $listVal,
                                    'identifier' => $block->identifier
                                ])
                            </div>
                        </div>
                    @elseif($block->identifier === 'university-management-page-first-section')
                        <div class="card border mb-3">
                            <div class="card-header fw-bold">University Management Hero</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Main Heading <span class="text-danger">*</span></label>
                                    <input type="text" name="content[heading1]" value="{{ flatten_rich_text($content['heading1'] ?? '') }}" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Intro Paragraph</label>
                                    <textarea name="content[content1]" class="form-control" rows="4">{{ flatten_rich_text($content['content1'] ?? '') }}</textarea>
                                    <small class="text-muted">Use new lines to create separate paragraphs.</small>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Hero Image Left URL</label>
                                        <input type="text" name="content[imageUrl1]" value="{{ is_array($content['imageUrl1'] ?? null) ? '' : ($content['imageUrl1'] ?? '') }}" class="form-control" placeholder="https://...">
                                        <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                                        <input type="file" name="images[imageUrl1]" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Hero Image Right URL</label>
                                        <input type="text" name="content[imageUrl2]" value="{{ is_array($content['imageUrl2'] ?? null) ? '' : ($content['imageUrl2'] ?? '') }}" class="form-control" placeholder="https://...">
                                        <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                                        <input type="file" name="images[imageUrl2]" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif($block->identifier === 'management-leadership')
                        <div class="card border mb-3">
                            <div class="card-header fw-bold">Leadership Team Section</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Heading</label>
                                    <input type="text" name="content[heading]" value="{{ flatten_rich_text($content['heading'] ?? '') }}" class="form-control" placeholder="University Leadership">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Subheading</label>
                                    <input type="text" name="content[subheading]" value="{{ flatten_rich_text($content['subheading'] ?? '') }}" class="form-control" placeholder="Principal Officers">
                                </div>
                                @include('dashboard.admin.blocks.partials.repeater', ['key' => 'additional_contents', 'value' => is_array($content['additional_contents'] ?? null) ? $content['additional_contents'] : [], 'identifier' => $block->identifier])
                            </div>
                        </div>
                    @elseif($block->identifier === 'management-other')
                        <div class="card border mb-3">
                            <div class="card-header fw-bold">Other Management Section</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Heading</label>
                                    <input type="text" name="content[heading]" value="{{ flatten_rich_text($content['heading'] ?? '') }}" class="form-control" placeholder="Management Team">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Subheading</label>
                                    <input type="text" name="content[subheading]" value="{{ flatten_rich_text($content['subheading'] ?? '') }}" class="form-control" placeholder="Heads of units and departments.">
                                </div>
                                @include('dashboard.admin.blocks.partials.repeater', ['key' => 'additional_contents', 'value' => is_array($content['additional_contents'] ?? null) ? $content['additional_contents'] : [], 'identifier' => $block->identifier])
                            </div>
                        </div>
                    @else
                    @forelse($content as $key => $value)
                        @if(!Str::endsWith($key, ['_alt', '_caption']))
                        <div class="mb-3 p-3 border rounded bg-light">
                            <label class="form-label fw-bold text-capitalize">
                                {{ str_replace('_', ' ', $key) }}
                                @if(in_array($key, $requiredKeys)) <span class="text-danger">*</span> @endif
                                <small class="text-muted fw-normal">({{ $key }})</small>
                            </label>

                            @if(is_array($value))
                                {{-- Repeater Field --}}
                                @include('dashboard.admin.blocks.partials.repeater', ['key' => $key, 'value' => $value, 'identifier' => $block->identifier])
                            @elseif(Str::contains(strtolower($key), ['image', 'img', 'photo', 'banner', 'logo']))
                                {{-- Image Field (URL + File Upload) --}}
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <label class="form-label fw-semibold small">Media URL (Image/Video)</label>
                                        <input type="text" name="content[{{ $key }}]" value="{{ is_array($value) ? '' : ($value ?? '') }}" class="form-control mb-2" placeholder="https://..." @if(in_array($key, $requiredKeys)) required @endif>
                                        @if(isset($fieldHelp[$key])) <small class="text-muted d-block mb-2">{{ $fieldHelp[$key] }}</small> @endif
                                        <label class="form-label fw-semibold small mt-2">Or Upload File</label>
                                        <input type="file" name="images[{{ $key }}]" class="form-control mb-2">

                                        {{-- Alt Text and Caption --}}
                                        <div class="row mt-2">
                                            <div class="col-md-6">
                                                <label class="form-label small text-muted">Alt Text</label>
                                                <input type="text" name="content[{{ $key }}_alt]" value="{{ $content[$key . '_alt'] ?? '' }}" class="form-control form-control-sm" placeholder="Describe image for accessibility">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label small text-muted">Caption</label>
                                                <input type="text" name="content[{{ $key }}_caption]" value="{{ $content[$key . '_caption'] ?? '' }}" class="form-control form-control-sm" placeholder="Image caption">
                                            </div>
                                        </div>

                                        <small class="text-muted d-block mt-2">Provide a direct URL or upload a file. Upload will override URL.</small>
                                    </div>
                                    <div class="col-md-4 text-center">
                                        @php
                                            $valStr = is_array($value) ? '' : ($value ?? '');
                                            $isYouTube = is_string($valStr) && (Str::contains($valStr, 'youtube.com') || Str::contains($valStr, 'youtu.be'));
                                            $isVideo = is_string($valStr) && (Str::endsWith($valStr, '.mp4') || Str::contains($valStr, '/video/'));
                                            $embedUrl = $valStr;
                                            if ($isYouTube) {
                                                if (Str::contains($valStr, 'watch?v=')) {
                                                    $query = parse_url($valStr, PHP_URL_QUERY);
                                                    parse_str($query, $qs);
                                                    $vid = $qs['v'] ?? null;
                                                    if ($vid) { $embedUrl = 'https://www.youtube.com/embed/' . $vid; }
                                                } elseif (Str::contains($valStr, 'youtu.be/')) {
                                                    $path = parse_url($valStr, PHP_URL_PATH);
                                                    $vid = $path ? basename($path) : null;
                                                    if ($vid) { $embedUrl = 'https://www.youtube.com/embed/' . $vid; }
                                                }
                                            }
                                        @endphp
                                        @if($valStr)
                                            @if($isYouTube)
                                                <iframe src="{{ $embedUrl }}" width="100%" height="100" class="rounded border" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                            @elseif($isVideo)
                                                <video src="{{ $valStr }}" controls class="rounded border" style="max-height: 100px; width: 100%;"></video>
                                            @else
                                                <img src="{{ $valStr }}" alt="{{ $content[$key . '_alt'] ?? $key }}" class="img-fluid rounded border" style="max-height: 100px;">
                                            @endif
                                            <div class="small text-muted mt-1 text-truncate">{{ $valStr }}</div>
                                        @else
                                            <span class="text-muted fst-italic">No media set</span>
                                        @endif
                                    </div>
                                </div>
                            @elseif(Str::length($value) > 100 || Str::contains(strtolower($key), ['desc', 'content', 'overview', 'text']))
                                {{-- Long Text --}}
                                <textarea name="content[{{ $key }}]" class="form-control" rows="4" @if(in_array($key, $requiredKeys)) required @endif>{{ flatten_rich_text($value) }}</textarea>
                                @if(isset($fieldHelp[$key])) <small class="text-muted d-block mt-1">{{ $fieldHelp[$key] }}</small> @endif
                            @else
                                {{-- Short Text --}}
                                <input type="text" name="content[{{ $key }}]" value="{{ flatten_rich_text($value) }}" class="form-control" @if(in_array($key, $requiredKeys)) required @endif>
                                @if(isset($fieldHelp[$key])) <small class="text-muted d-block mt-1">{{ $fieldHelp[$key] }}</small> @endif
                            @endif
                        </div>
                        @endif
                    @empty
                        <div class="alert alert-info">
                            No content fields defined. Add generic content below or switch to JSON mode.
                        </div>
                    @endforelse
                    @endif
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
                            <textarea name="content_json" id="content_json" rows="10" class="form-control font-monospace">{{ json_encode($content, JSON_PRETTY_PRINT) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" {{ old('is_active', $block->is_active?->value ?? $block->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save me-2"></i>Update Block
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add Row
        document.body.addEventListener('click', function(e) {
            if (e.target.closest('.add-row-btn')) {
                const btn = e.target.closest('.add-row-btn');
                const container = btn.closest('.repeater-container');
                const itemsContainer = container.querySelector('.repeater-items');
                const key = container.dataset.key;
                const schema = container.dataset.schema;
                const keys = JSON.parse(container.dataset.keys);
                const index = new Date().getTime(); // Unique index

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
                        // Capitalize
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
                
                // Remove empty message if exists
                const emptyMsg = itemsContainer.querySelector('.empty-message');
                if(emptyMsg) emptyMsg.remove();

                itemsContainer.insertAdjacentHTML('beforeend', html);
            }

            // Remove Row
            if (e.target.closest('.remove-row-btn')) {
                const btn = e.target.closest('.remove-row-btn');
                const item = btn.closest('.repeater-item');
                item.remove();
            }
        });
    });
</script>
 
@endsection
