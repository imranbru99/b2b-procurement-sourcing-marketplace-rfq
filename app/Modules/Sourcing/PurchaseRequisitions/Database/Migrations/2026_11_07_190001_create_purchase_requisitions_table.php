<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchase_requisitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->string('department')->nullable();
            $table->foreignId('requester_id')->constrained('users')->cascadeOnDelete();
            $table->string('status', 32)->default('draft');
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('currency', 3)->default('USD');
            $table->string('budget_code')->nullable();
            $table->unsignedTinyInteger('approval_level')->default(1);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('organization_id');
            $table->index(['organization_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchase_requisitions');
    }
};
