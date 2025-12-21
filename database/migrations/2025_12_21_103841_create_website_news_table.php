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
        Schema::create('website_news', function (Blueprint $table) {
            $table->id();
            $table->string('heading'); // Using 'heading' to match Contentful
            $table->string('subheading')->nullable();
            $table->string('slug')->unique();
            $table->string('image_url')->nullable(); // Contentful: imageUrl
            $table->longText('overview')->nullable(); // RichText
            $table->longText('content')->nullable(); // RichText
            
            // Contact/Social Info
            $table->string('email')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('instagram_url')->nullable();
            $table->string('twitter_url')->nullable();
            $table->string('youtube_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            
            $table->string('page')->nullable(); // e.g., 'home', 'news'
            $table->string('average_time_to_read')->nullable(); // Storing as string to be safe
            $table->string('author')->nullable();
            
            $table->timestamp('published_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_news');
    }
};
