<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('website_content_blocks', function (Blueprint $table) {
            if (!Schema::hasColumn('website_content_blocks', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    public function down(): void
    {
        Schema::table('website_content_blocks', function (Blueprint $table) {
            if (Schema::hasColumn('website_content_blocks', 'deleted_at')) {
                $table->dropSoftDeletes();
            }
        });
    }
};
