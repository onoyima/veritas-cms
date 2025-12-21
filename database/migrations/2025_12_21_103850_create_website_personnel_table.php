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
        Schema::create('website_personnel', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Maps to fullName
            $table->string('title')->nullable(); // e.g. Prof., Dr.
            $table->string('slug')->unique();
            $table->string('image_url')->nullable();
            $table->string('position')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->longText('biography')->nullable(); // RichText
            
            // Research/Management specific
            $table->string('role')->nullable(); // 'student', 'staff', 'others' (for research)
            
            // Socials (Management)
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('address')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
        // Pivot table for Course <-> Personnel (Staff)
        Schema::create('website_course_personnel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('website_courses')->onDelete('cascade');
            $table->foreignId('personnel_id')->constrained('website_personnel')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_course_personnel');
        Schema::dropIfExists('website_personnel');
    }
};
