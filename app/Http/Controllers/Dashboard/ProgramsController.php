<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\WebsiteProgram;
use App\Models\WebsiteCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Enums\ActiveStatus;
use Illuminate\Validation\Rules\Enum;

class ProgramsController extends Controller
{
    public function index()
    {
        $programs = WebsiteProgram::with('course')->orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.admin.programs.index', compact('programs'));
    }

    public function create()
    {
        $courses = WebsiteCourse::where('is_active', ActiveStatus::ACTIVE)->orderBy('course_name')->get();
        return view('dashboard.admin.programs.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'nullable|exists:website_courses,id',
            'program_category' => 'nullable|string|max:255',
            'program_level' => 'nullable|string|max:255',
            'degree' => 'nullable|string|max:255',
            'faculty' => 'nullable|string|max:255',
            'duration' => 'nullable|integer|min:1',
            'accredited_students' => 'nullable|integer|min:0',
            'slug' => 'nullable|string|max:255|unique:website_programs,slug',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|string',
            
            // Rich text content fields
            'program_description' => 'nullable|string',
            'eligibility_criteria' => 'nullable|string',
            'how_to_apply' => 'nullable|string',
            'financial_aid' => 'nullable|string',
            'research_facilities' => 'nullable|string',
            'transfer_candidates' => 'nullable|string',
            
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
        ]);

        // Handle Slug
        if (empty($validated['slug'])) {
            // Try to use course name if available, otherwise degree + program_category
            if (!empty($validated['course_id'])) {
                $course = WebsiteCourse::find($validated['course_id']);
                $base = $course ? $course->course_name : 'program';
            } else {
                $base = $validated['degree'] ?? 'program';
            }
            $validated['slug'] = Str::slug($base . '-' . ($validated['program_category'] ?? uniqid()));
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        // Handle Image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/programs', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        // Handle Rich Text Fields
        $richTextFields = [
            'program_description', 
            'eligibility_criteria', 
            'how_to_apply', 
            'financial_aid', 
            'research_facilities', 
            'transfer_candidates'
        ];

        foreach ($richTextFields as $field) {
            if (isset($validated[$field])) {
                $validated[$field] = $this->createRichText($validated[$field]);
            }
        }

        $validated['is_active'] = $validated['is_active'] ?? ActiveStatus::ACTIVE->value;

        WebsiteProgram::create($validated);

        return redirect()->route('admin.programs.index')->with('success', 'Program created successfully.');
    }

    public function edit(WebsiteProgram $program)
    {
        $courses = WebsiteCourse::where('is_active', ActiveStatus::ACTIVE)->orderBy('course_name')->get();
        
        // Extract text for editing
        $program->program_description_text = $this->extractTextFromRichText($program->program_description);
        $program->eligibility_criteria_text = $this->extractTextFromRichText($program->eligibility_criteria);
        $program->how_to_apply_text = $this->extractTextFromRichText($program->how_to_apply);
        $program->financial_aid_text = $this->extractTextFromRichText($program->financial_aid);
        $program->research_facilities_text = $this->extractTextFromRichText($program->research_facilities);
        $program->transfer_candidates_text = $this->extractTextFromRichText($program->transfer_candidates);

        return view('dashboard.admin.programs.edit', compact('program', 'courses'));
    }

    public function update(Request $request, WebsiteProgram $program)
    {
        $validated = $request->validate([
            'course_id' => 'nullable|exists:website_courses,id',
            'program_category' => 'nullable|string|max:255',
            'program_level' => 'nullable|string|max:255',
            'degree' => 'nullable|string|max:255',
            'faculty' => 'nullable|string|max:255',
            'duration' => 'nullable|integer|min:1',
            'accredited_students' => 'nullable|integer|min:0',
            'slug' => 'nullable|string|max:255|unique:website_programs,slug,' . $program->id,
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|string',
            
            'program_description' => 'nullable|string',
            'eligibility_criteria' => 'nullable|string',
            'how_to_apply' => 'nullable|string',
            'financial_aid' => 'nullable|string',
            'research_facilities' => 'nullable|string',
            'transfer_candidates' => 'nullable|string',
            
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($program->slug); // Keep existing if not provided
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/programs', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        // Handle Rich Text Fields
        $richTextFields = [
            'program_description', 
            'eligibility_criteria', 
            'how_to_apply', 
            'financial_aid', 
            'research_facilities', 
            'transfer_candidates'
        ];

        foreach ($richTextFields as $field) {
            if (isset($validated[$field])) {
                $validated[$field] = $this->createRichText($validated[$field]);
            } else {
                 // Keep old value if not present in request? 
                 // No, if it's not in request (and we use nullable), it might mean empty. 
                 // But typically form sends empty string.
                 // If null, we might want to clear it.
                 // However, we used $program->update($validated), so keys present in $validated will be updated.
            }
        }

        $validated['is_active'] = $validated['is_active'] ?? ActiveStatus::INACTIVE->value;

        $program->update($validated);

        return redirect()->route('admin.programs.index')->with('success', 'Program updated successfully.');
    }

    public function destroy(WebsiteProgram $program)
    {
        $program->delete();
        return redirect()->route('admin.programs.index')->with('success', 'Program deleted successfully.');
    }

    /**
     * Helper to create Contentful-like RichText structure
     */
    private function createRichText(?string $text): array
    {
        if (empty($text)) {
            return [];
        }

        $paragraphs = explode("\n", $text);
        $contentNodes = [];

        foreach ($paragraphs as $p) {
            if (trim($p) === '') continue;

            $contentNodes[] = [
                'nodeType' => 'paragraph',
                'data' => [],
                'content' => [
                    [
                        'nodeType' => 'text',
                        'value' => trim($p),
                        'marks' => [],
                        'data' => []
                    ]
                ]
            ];
        }

        return [
            'nodeType' => 'document',
            'data' => [],
            'content' => $contentNodes
        ];
    }

    /**
     * Helper to extract plain text from RichText structure
     */
    private function extractTextFromRichText($richText): string
    {
        if (empty($richText) || !is_array($richText) || !isset($richText['content'])) {
            return '';
        }

        $textParts = [];
        foreach ($richText['content'] as $node) {
            if (isset($node['content']) && is_array($node['content'])) {
                foreach ($node['content'] as $innerNode) {
                    if (isset($innerNode['value'])) {
                        $textParts[] = $innerNode['value'];
                    }
                }
            }
            $textParts[] = "\n"; // Add newline after each block (paragraph)
        }

        return trim(implode("", $textParts));
    }
}
