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
        Schema::create('website_content_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained('website_pages')->onDelete('cascade');
            $table->string('type'); // e.g., 'hero', 'features', 'text'
            $table->string('identifier')->nullable(); // Optional: specific identifier for the block
            $table->json('content')->nullable(); // The flexible content structure
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_content_blocks');
    }
};
