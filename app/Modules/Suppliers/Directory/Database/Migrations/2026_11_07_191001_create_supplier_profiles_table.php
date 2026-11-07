<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->string('company_name');
            $table->string('slug')->unique();
            $table->string('tagline')->nullable();
            $table->text('description')->nullable();
            $table->string('country', 2)->nullable();
            $table->string('region')->nullable();
            $table->string('city')->nullable();
            $table->decimal('lat', 10, 7)->nullable();
            $table->decimal('lng', 10, 7)->nullable();
            $table->string('website')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->decimal('rating_avg', 3, 2)->default(0);
            $table->unsignedInteger('rating_count')->default(0);
            $table->unsignedInteger('moq')->nullable();
            $table->string('capacity')->nullable();
            $table->string('business_type')->nullable();
            $table->unsignedInteger('employee_count')->nullable();
            $table->unsignedSmallInteger('year_founded')->nullable();
            $table->timestamps();

            $table->index(['country', 'region', 'city']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_profiles');
    }
};
