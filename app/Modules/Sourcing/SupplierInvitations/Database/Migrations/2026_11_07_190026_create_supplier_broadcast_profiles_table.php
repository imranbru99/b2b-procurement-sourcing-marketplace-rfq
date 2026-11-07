<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_broadcast_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->string('category')->nullable();
            $table->string('location')->nullable();
            $table->json('certifications')->nullable();
            $table->decimal('min_rating', 4, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('organization_id');
            $table->index(['category', 'location']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_broadcast_profiles');
    }
};
