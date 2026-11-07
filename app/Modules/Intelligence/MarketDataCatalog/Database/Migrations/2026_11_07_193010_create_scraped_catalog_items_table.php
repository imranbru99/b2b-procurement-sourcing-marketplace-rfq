<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scraped_catalog_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->nullable()->constrained()->nullOnDelete();
            $table->unsignedBigInteger('catalog_generation_id')->nullable()->index();
            $table->string('source_url', 2048)->nullable();
            $table->string('title');
            $table->decimal('price', 15, 4)->nullable();
            $table->string('currency', 3)->default('USD');
            $table->string('status', 32)->default('pending');
            $table->json('raw')->nullable();
            $table->timestamps();

            $table->index(['organization_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scraped_catalog_items');
    }
};
