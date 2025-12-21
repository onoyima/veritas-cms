<?php

use App\Models\ContentBlock;
use App\Models\Page;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$pagesToClean = [
    'about' => ['about_hero', 'about_foundation', 'about_management', 'about_journey'],
    'admissions' => ['admissions_hero', 'admissions_undergraduate', 'admissions_jupeb', 'admissions_ijamb', 'admissions_sandwich', 'admissions_postgraduate'],
    'research' => ['research_hero', 'research_focus', 'research_groups', 'research_spotlight'],
    'chaplaincy' => ['chaplaincy_hero', 'chaplaincy_focus', 'chaplaincy_holy_see', 'chaplaincy_mass'],
    'fees' => ['fees_hero', 'fees_calculation', 'fees_transfer']
];

foreach ($pagesToClean as $slug => $identifiers) {
    $page = Page::where('slug', $slug)->first();
    if ($page) {
        $deleted = ContentBlock::where('page_id', $page->id)
            ->whereIn('identifier', $identifiers)
            ->delete();
        echo "Deleted $deleted old blocks for page '$slug'.\n";
    } else {
        echo "Page '$slug' not found.\n";
    }
}
