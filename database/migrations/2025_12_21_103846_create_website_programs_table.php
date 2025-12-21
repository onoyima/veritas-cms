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
        Schema::create('website_programs', function (Blueprint $table) {
            $table->id();
            // Basic Info
            $table->string('slug')->unique();
            $table->string('program_category')->nullable(); // e.g. undergraduate, postgraduate
            $table->string('program_level')->nullable();
            $table->string('degree')->nullable(); // B.Sc, M.Sc
            $table->string('faculty')->nullable();
            $table->integer('duration')->nullable(); // in years
            $table->integer('accredited_students')->nullable();
            $table->string('image_url')->nullable();
            
            // Rich Text Fields
            $table->longText('program_description')->nullable();
            $table->longText('eligibility_criteria')->nullable();
            $table->longText('how_to_apply')->nullable();
            $table->longText('financial_aid')->nullable();
            $table->longText('research_facilities')->nullable();
            $table->longText('transfer_candidates')->nullable();
            
            // Relationships handled in course or via pivot
            // But ProgramSkeleton has `course: Entry<CourseSkeleton>`
            // If it's 1:1, we can put course_id here, or just embed course fields.
            // Since `Course` has `staff`, it seems significant.
            // Let's create website_courses and link it.
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_programs');
    }
};
