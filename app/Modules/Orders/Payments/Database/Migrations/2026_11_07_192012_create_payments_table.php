<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('invoice_id')->nullable()->constrained('invoices')->nullOnDelete();
            $table->string('reference')->nullable();
            $table->string('status', 32)->default('pending');
            $table->string('method', 32)->default('bank_transfer');
            $table->string('gateway', 32)->nullable();
            $table->string('currency', 3)->default('USD');
            $table->decimal('amount', 15, 2)->default(0);
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index('organization_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
