<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Enums\PageStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Using DB::statement to modify column type to ENUM directly
        $statuses = array_map(fn($case) => "'$case->value'", PageStatus::cases());
        $enumString = implode(',', $statuses);
        
        DB::statement("ALTER TABLE website_pages MODIFY COLUMN status ENUM($enumString) DEFAULT 'draft'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE website_pages MODIFY COLUMN status VARCHAR(255) DEFAULT 'draft'");
    }
};
