<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('escrow_milestones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('escrow_wallet_id')->constrained('escrow_wallets')->cascadeOnDelete();
            $table->string('title');
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('status', 32)->default('pending');
            $table->timestamp('released_at')->nullable();
            $table->timestamps();

            $table->index('organization_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('escrow_milestones');
    }
};
