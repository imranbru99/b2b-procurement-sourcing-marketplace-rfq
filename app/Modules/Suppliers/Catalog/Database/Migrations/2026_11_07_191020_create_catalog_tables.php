<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('supplier_category_id')->nullable()->constrained('supplier_categories')->nullOnDelete();
            $table->foreignId('supplier_profile_id')->nullable()->constrained('supplier_profiles')->nullOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->string('sku')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 15, 4)->nullable();
            $table->string('currency', 3)->default('USD');
            $table->unsignedInteger('moq')->nullable();
            $table->unsignedInteger('stock')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('variants')->nullable();
            $table->timestamps();

            $table->unique(['organization_id', 'slug']);
            $table->index(['organization_id', 'sku']);
        });

        Schema::create('product_price_tiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->unsignedInteger('min_quantity');
            $table->unsignedInteger('max_quantity')->nullable();
            $table->decimal('unit_price', 15, 4);
            $table->timestamps();
        });

        Schema::create('product_special_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('buyer_organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->decimal('unit_price', 15, 4);
            $table->date('valid_from')->nullable();
            $table->date('valid_until')->nullable();
            $table->timestamps();

            $table->unique(['product_id', 'buyer_organization_id'], 'product_special_prices_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_special_prices');
        Schema::dropIfExists('product_price_tiers');
        Schema::dropIfExists('products');
    }
};
