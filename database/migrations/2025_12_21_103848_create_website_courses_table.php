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
        Schema::create('website_courses', function (Blueprint $table) {
            $table->id();
            // Relationship
            // A Program has a Course. In Contentful, Program has a link to Course.
            // We can add program_id here if 1:many or put course_id in programs if 1:1.
            // Given "Course" sounds like the academic entity and "Program" the wrapper.
            // Let's assume 1:1 for simplicity or 1:Many.
            // I'll add a foreign key in `website_programs` to `website_courses` later, or just link them here.
            // Actually, let's just make it independent and link via pivot or FK.
            // Contentful: Program -> Course. So Program belongsTo Course (or hasOne).
            
            $table->string('course_name');
            $table->string('slug')->unique();
            $table->string('faculty')->nullable();
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
        
        // Add foreign key to programs table
        Schema::table('website_programs', function (Blueprint $table) {
            $table->foreignId('course_id')->nullable()->constrained('website_courses')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_programs', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropColumn('course_id');
        });
        Schema::dropIfExists('website_courses');
    }
};
