@php
    if (!function_exists('flatten_rich_text')) {
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
    }
    $identifier = $identifier ?? null;
    // Detect type of array
    $isSimpleArray = !empty($value) && !is_array(array_values($value)[0] ?? null);
    // If empty, default to simple array unless key suggests otherwise (like 'stats', 'items')
    if (empty($value)) {
        if (in_array($key, ['stats', 'items', 'quick_links', 'admissions', 'course_fees', 'accommodation_fees', 'school_accounts', 'research_groups', 'publications', 'sdgs'])) {
            $isSimpleArray = false;
        } else {
            $isSimpleArray = true;
        }
    }

    $sampleItem = $isSimpleArray ? '' : ($value[0] ?? []);
    if ($key === 'content5' && $identifier === 'about-page-third-section') {
        $isSimpleArray = false;
        $sampleItem = ['title' => '', 'description' => ''];
    }
    
    // If empty object array, try to infer keys from key name or use a generic 'value' key if we can't guess
    if (!$isSimpleArray && empty($sampleItem)) {
         if ($key === 'stats') {
             $sampleItem = ['id' => '', 'value' => '', 'suffix' => '', 'label' => ''];
         } elseif ($key === 'items') {
             // Customize per block identifier
             switch ($identifier) {
                 case 'home-discover':
                     $sampleItem = ['id' => '', 'title' => '', 'subtitle' => '', 'description' => '', 'image_url' => '', 'href' => ''];
                     break;
                 case 'home-services':
                     $sampleItem = ['id' => '', 'title' => '', 'href' => '', 'imgSrc' => ''];
                     break;
                 case 'home-admissions':
                     $sampleItem = ['id' => '', 'title' => '', 'imgSrc' => '', 'href' => ''];
                     break;
                 default:
                     $sampleItem = ['title' => '', 'description' => '', 'image_url' => '', 'href' => ''];
                     break;
             }
         } elseif ($key === 'quick_links') {
             $sampleItem = ['title' => '', 'href' => ''];
         } else {
             $sampleItem = ['key' => '', 'value' => '']; // Fallback
         }
    }

    $keys = $isSimpleArray ? [] : array_keys($sampleItem);
    // Ensure required fields appear even if existing items lack them
    $required = [];
    if (!$isSimpleArray) {
        if ($key === 'items') {
            switch ($identifier) {
                case 'home-discover':
                    $required = ['id', 'title', 'subtitle', 'description', 'image_url', 'href'];
                    break;
                case 'home-services':
                    $required = ['id', 'title', 'href', 'imgSrc'];
                    break;
                case 'home-admissions':
                    $required = ['id', 'title', 'imgSrc', 'href'];
                    break;
            }
        } elseif ($key === 'content5' && $identifier === 'about-page-third-section') {
            $required = ['title', 'description'];
        } elseif ($key === 'quick_links') {
            $required = ['title', 'href'];
        } elseif ($key === 'stats') {
            $required = ['id', 'value', 'suffix', 'label'];
        }
        if (!empty($required)) {
            $keys = array_values(array_unique(array_merge($keys, $required)));
        }
    }
@endphp

<div class="repeater-container card bg-light mb-3" data-key="{{ $key }}" data-schema="{{ $isSimpleArray ? 'simple' : 'object' }}" data-keys="{{ json_encode($keys) }}">
    <div class="card-header d-flex justify-content-between align-items-center py-2">
        <span class="fw-bold text-capitalize small">{{ str_replace('_', ' ', $key) }} (List)</span>
        <button type="button" class="btn btn-outline-primary btn-sm add-row-btn" style="font-size: 0.75rem; padding: 0.2rem 0.5rem;">
            <i class="fa-solid fa-plus me-1"></i> Add Item
        </button>
    </div>
    <div class="card-body p-2 repeater-items">
        @forelse($value as $index => $item)
            <div class="repeater-item card mb-2 p-2 bg-white border shadow-sm">
                <div class="d-flex justify-content-end mb-1">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-row-btn" style="padding: 0px 5px; font-size: 0.7rem;" title="Remove Item">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
                <div class="row g-2">
                    @if($isSimpleArray)
                        <div class="col-12">
                            <input type="text" name="content[{{ $key }}][{{ $index }}]" value="{{ flatten_rich_text(is_array($item) ? '' : $item) }}" class="form-control form-control-sm" placeholder="Value">
                        </div>
                    @else
                        @foreach($keys as $field)
                            <div class="col-md-6">
                                <label class="form-label small text-muted text-capitalize mb-0" style="font-size: 0.7rem;">{{ str_replace('_', ' ', $field) }}</label>
                                @if(str_contains($field, 'image') || str_contains($field, 'img') || str_contains($field, 'src'))
                                    <div class="mb-1">
                                        <input type="text" name="content[{{ $key }}][{{ $index }}][{{ $field }}]" value="{{ is_array($item[$field] ?? '') ? '' : ($item[$field] ?? '') }}" class="form-control form-control-sm mb-1" placeholder="Image URL">
                                        <input type="file" name="files[{{ $key }}][{{ $index }}][{{ $field }}]" class="form-control form-control-sm">
                                        <small class="text-muted" style="font-size: 0.65rem;">Upload new file to replace URL</small>
                                    </div>
                                @else
                                    @php
                                        $val = '';
                                        if (is_array($item)) {
                                            $val = flatten_rich_text($item[$field] ?? '');
                                        } else {
                                            // Handle legacy simple strings for object schema (e.g., Core Values as strings)
                                            if ($field === 'title' && is_string($item)) {
                                                $val = flatten_rich_text($item);
                                            } else {
                                                $val = '';
                                            }
                                        }
                                    @endphp
                                    <input type="text" name="content[{{ $key }}][{{ $index }}][{{ $field }}]" value="{{ $val }}" class="form-control form-control-sm">
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center text-muted small py-2 empty-message">No items. Click "Add Item" to start.</div>
        @endforelse
    </div>
</div>
