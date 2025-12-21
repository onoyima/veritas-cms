<?php

use App\Models\Page;
use App\Models\ContentBlock;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$page = Page::where('slug', 'home')->first();

if (!$page) {
    echo "Page 'home' not found.\n";
    exit(1);
}

echo "Page ID: " . $page->id . "\n";
$blocks = ContentBlock::where('page_id', $page->id)->orderBy('order')->get();
echo "Blocks Found: " . $blocks->count() . "\n";

foreach ($blocks as $block) {
    echo "--------------------------------------------------\n";
    echo "Identifier: " . $block->identifier . "\n";
    echo "Type: " . $block->type . "\n";
    echo "Content: " . json_encode($block->content, JSON_PRETTY_PRINT) . "\n";
}
