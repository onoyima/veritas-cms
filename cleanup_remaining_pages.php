<?php

use App\Models\Page;
use App\Models\ContentBlock;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$pagesToClean = [
    'news-and-events' => ['news_hero', 'news_highlighted', 'news_listing'],
    'undergraduate' => ['undergraduate_hero', 'undergraduate_stats', 'undergraduate_listing', 'undergraduate_cta'],
    'postgraduate' => ['postgraduate_hero', 'postgraduate_listing'],
    // Also clean up potential duplicates if seeder was run partially
    'a-z' => ['a-z-page-hero', 'a-z-listing'],
    'faq' => ['faq-page-hero', 'faq-listing'],
    'university-management' => ['management-page-hero', 'management-leadership', 'management-other']
];

foreach ($pagesToClean as $slug => $identifiers) {
    $page = Page::where('slug', $slug)->first();
    if ($page) {
        $deleted = ContentBlock::where('page_id', $page->id)
            ->whereIn('identifier', $identifiers)
            ->delete();
        echo "Deleted $deleted blocks for page '$slug'.\n";
    } else {
        echo "Page '$slug' not found (might not be seeded yet).\n";
    }
}
