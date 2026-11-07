<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('purchase_order_id')->nullable()->constrained('purchase_orders')->nullOnDelete();
            $table->foreignId('grn_id')->nullable()->constrained('grns')->nullOnDelete();
            $table->string('number');
            $table->string('status', 32)->default('draft');
            $table->string('currency', 3)->default('USD');
            $table->decimal('subtotal', 15, 2)->default(0);
            $table->string('tax_type', 16)->nullable();
            $table->decimal('tax_rate', 8, 4)->default(0);
            $table->decimal('tax_total', 15, 2)->default(0);
            $table->decimal('total', 15, 2)->default(0);
            $table->timestamp('issued_at')->nullable();
            $table->timestamp('due_at')->nullable();
            $table->timestamps();

            $table->index('organization_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
