<?php

use App\Models\Page;
use App\Models\ContentBlock;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$expectedPages = [
    'home', 'about', 'admissions', 'campus-life', 'chaplaincy', 
    'fees', 'research', 'news-and-events', 'undergraduate', 
    'postgraduate', 'a-z', 'faq', 'university-management'
];

echo "--- Verifying All Pages ---\n";

foreach ($expectedPages as $slug) {
    $page = Page::where('slug', $slug)->first();
    if ($page) {
        echo "\n[OK] Page '$slug' found (ID: {$page->id})\n";
        $blocks = ContentBlock::where('page_id', $page->id)->orderBy('order')->get();
        echo "     Blocks: " . $blocks->count() . "\n";
        foreach ($blocks as $block) {
            echo "     - [{$block->identifier}] {$block->name} (Type: {$block->type})\n";
        }
    } else {
        echo "\n[FAIL] Page '$slug' NOT found!\n";
    }
}
