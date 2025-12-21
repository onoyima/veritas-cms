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
        Schema::create('website_a_z_entries', function (Blueprint $table) {
            $table->id();
            $table->char('alphabet', 1)->index(); // A, B, C...
            $table->string('topic'); // Name of the entry (e.g., About Us)
            $table->string('slug')->nullable();
            $table->string('link')->nullable(); // /about
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_a_z_entries');
    }
};
