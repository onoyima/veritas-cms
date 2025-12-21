<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('website_personnel', function (Blueprint $table) {
            if (!Schema::hasColumn('website_personnel', 'title')) {
                $table->string('title')->nullable()->after('name');
            }
            if (!Schema::hasColumn('website_personnel', 'image_url')) {
                $table->string('image_url')->nullable()->after('slug');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_personnel', function (Blueprint $table) {
            if (Schema::hasColumn('website_personnel', 'title')) {
                $table->dropColumn('title');
            }
            if (Schema::hasColumn('website_personnel', 'image_url')) {
                $table->dropColumn('image_url');
            }
        });
    }
};
