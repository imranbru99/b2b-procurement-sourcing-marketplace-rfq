<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_storefronts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_profile_id')->unique()->constrained('supplier_profiles')->cascadeOnDelete();
            $table->boolean('is_published')->default(false);
            $table->string('hero_title')->nullable();
            $table->string('hero_subtitle')->nullable();
            $table->json('theme')->nullable();
            $table->json('seo')->nullable();
            $table->string('custom_domain')->nullable();
            $table->timestamps();
        });

        Schema::create('portfolio_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_profile_id')->constrained('supplier_profiles')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('client_name')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });

        Schema::create('supplier_factories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_profile_id')->constrained('supplier_profiles')->cascadeOnDelete();
            $table->string('name');
            $table->string('country', 2)->nullable();
            $table->string('city')->nullable();
            $table->unsignedInteger('capacity_units')->nullable();
            $table->text('capabilities')->nullable();
            $table->timestamps();
        });

        Schema::create('supplier_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_profile_id')->constrained('supplier_profiles')->cascadeOnDelete();
            $table->string('title');
            $table->string('url');
            $table->string('provider')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('supplier_downloads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_profile_id')->constrained('supplier_profiles')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('requires_lead_unlock')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_downloads');
        Schema::dropIfExists('supplier_videos');
        Schema::dropIfExists('supplier_factories');
        Schema::dropIfExists('portfolio_items');
        Schema::dropIfExists('supplier_storefronts');
    }
};
