<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_certifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_profile_id')->constrained('supplier_profiles')->cascadeOnDelete();
            $table->string('name');
            $table->string('issuing_body')->nullable();
            $table->string('certificate_number')->nullable();
            $table->date('issued_at')->nullable();
            $table->date('expires_at')->nullable();
            $table->string('verification_url')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_certifications');
    }
};
