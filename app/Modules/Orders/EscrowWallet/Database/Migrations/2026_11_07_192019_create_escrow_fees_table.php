<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('escrow_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('escrow_wallet_id')->constrained('escrow_wallets')->cascadeOnDelete();
            $table->string('fee_type', 32)->default('commission');
            $table->decimal('rate', 8, 4)->default(0);
            $table->decimal('amount', 15, 2)->default(0);
            $table->timestamps();

            $table->index('organization_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('escrow_fees');
    }
};
