<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('price_benchmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->nullable()->constrained()->nullOnDelete();
            $table->string('category', 128)->nullable();
            $table->string('sku', 64)->nullable();
            $table->string('title');
            $table->decimal('median_price', 15, 4);
            $table->decimal('p25_price', 15, 4)->nullable();
            $table->decimal('p75_price', 15, 4)->nullable();
            $table->string('currency', 3)->default('USD');
            $table->unsignedInteger('sample_size')->default(0);
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['organization_id', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_benchmarks');
    }
};
