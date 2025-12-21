<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix column type using raw SQL to avoid doctrine dependency issues
        DB::statement('ALTER TABLE website_pages MODIFY COLUMN created_by INT(10) UNSIGNED NULL');

        Schema::table('website_pages', function (Blueprint $table) {
            // Add the foreign key constraint now that types match
            $table->foreign('created_by')->references('id')->on('staff')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_pages', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
        });

        // Revert to bigint (foreignId default)
        DB::statement('ALTER TABLE website_pages MODIFY COLUMN created_by BIGINT(20) UNSIGNED NULL');
    }
};
