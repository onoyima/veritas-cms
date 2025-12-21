<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\WebsiteNews;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Enums\ActiveStatus;
use Illuminate\Validation\Rules\Enum;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = WebsiteNews::orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'heading' => 'required|string|max:255',
            'subheading' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:website_news,slug',
            'author' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048', // File upload
            'image_url' => 'nullable|string', // Or URL
            'overview' => 'nullable|string',
            'content' => 'nullable|string',
            'published_at' => 'nullable|date',
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
        ]);

        // Auto-generate slug
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['heading']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        // Handle Image Upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/news', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        // Wrap Text in RichText Structure
        $validated['overview'] = $this->createRichText($validated['overview'] ?? '');
        $validated['content'] = $this->createRichText($validated['content'] ?? '');

        // Defaults
        $validated['is_active'] = $validated['is_active'] ?? ActiveStatus::ACTIVE->value;
        $validated['published_at'] = $validated['published_at'] ?? now();

        WebsiteNews::create($validated);

        return redirect()->route('admin.news.index')->with('success', 'News created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WebsiteNews $news)
    {
        // Extract text from RichText for editing
        $news->overview_text = $this->extractTextFromRichText($news->overview);
        $news->content_text = $this->extractTextFromRichText($news->content);

        return view('dashboard.admin.news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WebsiteNews $news)
    {
        $validated = $request->validate([
            'heading' => 'required|string|max:255',
            'subheading' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:website_news,slug,' . $news->id,
            'author' => 'nullable|string|max:255',
            'image' => 'nullable|image|max:2048',
            'image_url' => 'nullable|string',
            'overview' => 'nullable|string',
            'content' => 'nullable|string',
            'published_at' => 'nullable|date',
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['heading']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/news', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        $validated['overview'] = $this->createRichText($validated['overview'] ?? '');
        $validated['content'] = $this->createRichText($validated['content'] ?? '');
        $validated['is_active'] = $validated['is_active'] ?? ActiveStatus::INACTIVE->value;

        $news->update($validated);

        return redirect()->route('admin.news.index')->with('success', 'News updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WebsiteNews $news)
    {
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'News deleted successfully.');
    }

    /**
     * Helper to create Contentful-like RichText structure
     */
    private function createRichText(?string $text): array
    {
        if (empty($text)) return [];

        // Split by newlines to create multiple paragraphs
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
     * Helper to extract text from RichText structure
     */
    private function extractTextFromRichText($richText): string
    {
        if (empty($richText) || !isset($richText['content'])) return '';

        $text = '';
        foreach ($richText['content'] as $node) {
            if ($node['nodeType'] === 'paragraph') {
                foreach ($node['content'] as $innerNode) {
                    if ($innerNode['nodeType'] === 'text') {
                        $text .= $innerNode['value'] . "\n\n";
                    }
                }
            }
        }

        return trim($text);
    }
}
