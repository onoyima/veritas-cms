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
        Schema::create('website_publications', function (Blueprint $table) {
            $table->id();
            $table->string('title1')->nullable();
            $table->string('title2')->nullable();
            $table->string('image_url')->nullable();
            $table->string('additional_info')->nullable();
            $table->string('category')->nullable();
            $table->string('publication_url')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
        // Pivot table for Personnel <-> Publications
        Schema::create('website_personnel_publications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personnel_id')->constrained('website_personnel')->onDelete('cascade');
            $table->foreignId('publication_id')->constrained('website_publications')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_personnel_publications');
        Schema::dropIfExists('website_publications');
    }
};
