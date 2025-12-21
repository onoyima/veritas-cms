<?php

use App\Models\Page;
use App\Models\ContentBlock;
use App\Models\WebsiteResearchGroup;
use Illuminate\Support\Facades\Schema;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "--- Verifying Research Page ---\n";
$researchPage = Page::where('slug', 'research')->first();
if ($researchPage) {
    echo "Research Page found (ID: {$researchPage->id})\n";
    $blocks = ContentBlock::where('page_id', $researchPage->id)->orderBy('order')->get();
    echo "Found " . $blocks->count() . " blocks:\n";
    foreach ($blocks as $block) {
        echo "- [{$block->identifier}] {$block->name} (Type: {$block->type})\n";
        // print_r($block->content);
    }
} else {
    echo "Research Page NOT found!\n";
}

echo "\n--- Verifying Website Research Groups ---\n";
$groups = WebsiteResearchGroup::all();
echo "Found " . $groups->count() . " research groups:\n";
foreach ($groups as $group) {
    echo "- {$group->title} (Slug: {$group->slug})\n";
    echo "  Description: " . substr($group->description, 0, 50) . "...\n";
}

echo "\n--- Verifying About Page ---\n";
$aboutPage = Page::where('slug', 'about')->first();
if ($aboutPage) {
    echo "About Page found (ID: {$aboutPage->id})\n";
    $blocks = ContentBlock::where('page_id', $aboutPage->id)->orderBy('order')->get();
    echo "Found " . $blocks->count() . " blocks:\n";
    foreach ($blocks as $block) {
        echo "- [{$block->identifier}] {$block->name} (Type: {$block->type})\n";
    }
} else {
    echo "About Page NOT found!\n";
}
