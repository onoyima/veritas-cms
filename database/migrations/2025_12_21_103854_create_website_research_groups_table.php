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
        Schema::create('website_research_groups', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('image_url')->nullable();
            $table->longText('spotlight')->nullable();
            $table->string('spotlight_url')->nullable();
            $table->string('spotlight_image')->nullable();
            
            // Research Focus Areas
            $table->string('research_focus_title1')->nullable();
            $table->string('research_focus_content1')->nullable();
            $table->string('research_focus_image_url1')->nullable();
            
            $table->string('research_focus_title2')->nullable();
            $table->string('research_focus_content2')->nullable();
            $table->string('research_focus_image_url2')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
        // Pivot: Research Group <-> Researchers (Personnel)
        Schema::create('website_research_group_researchers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('research_group_id')->constrained('website_research_groups')->onDelete('cascade');
            $table->foreignId('personnel_id')->constrained('website_personnel')->onDelete('cascade');
            $table->timestamps();
        });
        
        // Pivot: Research Group <-> Publications
        Schema::create('website_research_group_publications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('research_group_id')->constrained('website_research_groups')->onDelete('cascade');
            $table->foreignId('publication_id')->constrained('website_publications')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_research_group_publications');
        Schema::dropIfExists('website_research_group_researchers');
        Schema::dropIfExists('website_research_groups');
    }
};
