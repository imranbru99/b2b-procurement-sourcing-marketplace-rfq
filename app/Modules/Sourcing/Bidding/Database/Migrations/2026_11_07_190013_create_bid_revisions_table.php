<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bid_revisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bid_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('revision_number')->default(1);
            $table->decimal('total', 15, 2)->default(0);
            $table->json('snapshot')->nullable();
            $table->timestamp('revised_at')->nullable();
            $table->timestamps();

            $table->index('organization_id');
            $table->index('bid_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bid_revisions');
    }
};
