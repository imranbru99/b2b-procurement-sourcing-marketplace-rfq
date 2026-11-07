<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rfq_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('rfq_id')->constrained()->cascadeOnDelete();
            $table->string('description');
            $table->decimal('quantity', 15, 4)->default(1);
            $table->string('unit', 32)->nullable();
            $table->decimal('estimated_unit_price', 15, 2)->nullable();
            $table->string('specifications')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();

            $table->index('organization_id');
            $table->index('rfq_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rfq_items');
    }
};
