<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rfq_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('rfq_id')->constrained()->cascadeOnDelete();
            $table->foreignId('asked_by_organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->foreignId('asked_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('question');
            $table->boolean('is_public')->default(true);
            $table->timestamps();

            $table->index('organization_id');
            $table->index('rfq_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rfq_questions');
    }
};
