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
        Schema::create('seo_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('seoable_type')->nullable(); // Model type (Article, Product, etc.)
            $table->uuid('seoable_id')->nullable(); // Model ID
            $table->string('route_name')->nullable(); // Route name (home, blog.index, etc.)
            $table->string('page_type')->default('page'); // page, article, product, etc.
            
            // Basic Meta Tags
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('meta_robots')->default('index,follow');
            $table->string('canonical_url')->nullable();
            
            // Open Graph Tags
            $table->string('og_title')->nullable();
            $table->text('og_description')->nullable();
            $table->string('og_image')->nullable();
            $table->string('og_type')->default('website');
            $table->string('og_url')->nullable();
            $table->string('og_site_name')->nullable();
            
            // Twitter Card Tags
            $table->string('twitter_card')->default('summary_large_image');
            $table->string('twitter_title')->nullable();
            $table->text('twitter_description')->nullable();
            $table->string('twitter_image')->nullable();
            $table->string('twitter_site')->nullable();
            $table->string('twitter_creator')->nullable();
            
            // Schema.org JSON-LD
            $table->json('schema_json')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index(['seoable_type', 'seoable_id']);
            $table->index('route_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_settings');
    }
};
