<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('rfq_id')->constrained()->cascadeOnDelete();
            $table->foreignId('supplier_organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->string('status', 16)->default('draft');
            $table->decimal('total', 15, 2)->default(0);
            $table->string('currency', 3)->default('USD');
            $table->unsignedInteger('lead_time_days')->nullable();
            $table->timestamp('valid_until')->nullable();
            $table->boolean('is_sealed')->default(true);
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();

            $table->index('organization_id');
            $table->index(['rfq_id', 'supplier_organization_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bids');
    }
};
