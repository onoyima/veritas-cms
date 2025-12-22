<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\WebsiteFaq;
use Illuminate\Http\Request;
use App\Enums\ActiveStatus;
use Illuminate\Validation\Rules\Enum;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = WebsiteFaq::orderBy('order', 'asc')->orderBy('created_at', 'desc')->paginate(10);
        return view('dashboard.admin.faqs.index', compact('faqs'));
    }

    public function create()
    {
        return view('dashboard.admin.faqs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
        ]);

        $validated['order'] = $validated['order'] ?? 0;
        $validated['is_active'] = $validated['is_active'] ?? ActiveStatus::ACTIVE->value;

        WebsiteFaq::create($validated);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ created successfully.');
    }

    public function edit(WebsiteFaq $faq)
    {
        return view('dashboard.admin.faqs.edit', compact('faq'));
    }

    public function update(Request $request, WebsiteFaq $faq)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => ['nullable', new Enum(ActiveStatus::class)],
        ]);

        $validated['is_active'] = $validated['is_active'] ?? ActiveStatus::INACTIVE->value;

        $faq->update($validated);

        return redirect()->route('admin.faqs.index')->with('success', 'FAQ updated successfully.');
    }

    public function destroy(WebsiteFaq $faq)
    {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with('success', 'FAQ deleted successfully.');
    }
}
