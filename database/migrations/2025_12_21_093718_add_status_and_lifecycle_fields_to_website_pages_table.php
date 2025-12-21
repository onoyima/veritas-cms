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
        Schema::table('website_pages', function (Blueprint $table) {
            if (!Schema::hasColumn('website_pages', 'status')) {
                $table->string('status')->default('draft')->after('is_active'); // draft, pending, published, archived
            }
            if (!Schema::hasColumn('website_pages', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('status');
            }
            if (!Schema::hasColumn('website_pages', 'published_at')) {
                $table->timestamp('published_at')->nullable()->after('created_at');
            }
            if (!Schema::hasColumn('website_pages', 'archived_at')) {
                $table->timestamp('archived_at')->nullable()->after('published_at');
            }
            if (!Schema::hasColumn('website_pages', 'deleted_at')) {
                $table->softDeletes()->after('updated_at');
            }

            // Use unsignedInteger because 'staff' table id is int(10) unsigned
            if (!Schema::hasColumn('website_pages', 'created_by')) {
                $table->unsignedInteger('created_by')->nullable()->after('deleted_at');
                $table->foreign('created_by')->references('id')->on('staff')->nullOnDelete();
            }

            if (!Schema::hasColumn('website_pages', 'approved_by')) {
                $table->unsignedInteger('approved_by')->nullable()->after('created_by');
                $table->foreign('approved_by')->references('id')->on('staff')->nullOnDelete();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_pages', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['status', 'is_featured', 'published_at', 'archived_at', 'deleted_at', 'created_by', 'approved_by']);
        });
    }
};
