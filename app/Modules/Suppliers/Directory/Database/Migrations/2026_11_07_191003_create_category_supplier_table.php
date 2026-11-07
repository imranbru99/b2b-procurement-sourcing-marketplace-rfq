<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_supplier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_category_id')->constrained('supplier_categories')->cascadeOnDelete();
            $table->foreignId('supplier_profile_id')->constrained('supplier_profiles')->cascadeOnDelete();
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->unique(['supplier_category_id', 'supplier_profile_id'], 'category_supplier_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_supplier');
    }
};
