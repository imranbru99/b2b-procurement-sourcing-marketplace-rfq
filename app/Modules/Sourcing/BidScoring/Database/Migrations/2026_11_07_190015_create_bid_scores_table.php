<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bid_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bid_id')->constrained()->cascadeOnDelete();
            $table->foreignId('scoring_criterion_id')->constrained()->cascadeOnDelete();
            $table->foreignId('evaluator_id')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('score', 8, 2)->default(0);
            $table->decimal('weighted_score', 12, 4)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['bid_id', 'scoring_criterion_id', 'evaluator_id'], 'bid_scores_unique');
            $table->index('organization_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bid_scores');
    }
};
