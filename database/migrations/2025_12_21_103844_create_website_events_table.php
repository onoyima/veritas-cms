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
        Schema::create('website_events', function (Blueprint $table) {
            $table->id();
            $table->string('heading');
            $table->string('subheading')->nullable();
            $table->string('slug')->unique()->nullable(); // Contentful doesn't enforce slug on events, but good to have
            $table->string('image_url')->nullable();
            $table->string('location')->nullable();
            $table->dateTime('start_date_and_time')->nullable();
            $table->dateTime('end_date_and_time')->nullable();
            $table->string('event_type')->nullable(); // e.g. 'social', 'academic'
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_events');
    }
};
