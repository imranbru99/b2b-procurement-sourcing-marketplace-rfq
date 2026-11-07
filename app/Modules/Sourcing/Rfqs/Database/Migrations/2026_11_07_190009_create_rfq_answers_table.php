<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rfq_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('rfq_question_id')->constrained()->cascadeOnDelete();
            $table->foreignId('answered_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->text('answer');
            $table->timestamps();

            $table->index('organization_id');
            $table->index('rfq_question_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rfq_answers');
    }
};
