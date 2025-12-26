<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageContentController extends Controller
{
    /**
     * Get page content by slug.
     * This endpoint will be consumed by Next.js to render pages dynamically.
     */
    public function show($slug)
    {
        // Try to find the page by slug
        $page = Page::where('slug', $slug)
            ->where('is_active', true)
            ->with(['blocks' => function ($query) {
                $query->where('is_active', true)->orderBy('order');
            }])
            ->first();

        if (!$page) {
            return response()->json([
                'error' => 'Page not found',
                'slug' => $slug
            ], 404);
        }

        // Return the page data with its content blocks
        return response()->json([
            'data' => [
                'id' => $page->id,
                'title' => $page->title,
                'slug' => $page->slug,
                'content' => $page->content,
                'image_url' => $page->image_url,
                'meta' => [
                    'title' => $page->meta_title,
                    'description' => $page->meta_description,
                ],
                'blocks' => $page->blocks->map(function ($block) {
                    return [
                        'id' => $block->id,
                        'type' => $block->type,
                        'identifier' => $block->identifier,
                        'content' => $block->content,
                        'order' => $block->order,
                    ];
                }),
                'updated_at' => $page->updated_at,
            ]
        ]);
    }

    /**
     * Get all active pages (for sitemap or navigation).
     */
    public function index()
    {
        $pages = Page::where('is_active', true)
            ->select('title', 'slug', 'updated_at')
            ->get();

        return response()->json([
            'data' => $pages
        ]);
    }
}
