<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('counter_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('negotiation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('offered_by_organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->decimal('amount', 15, 2);
            $table->string('currency', 3)->default('USD');
            $table->string('status', 16)->default('pending');
            $table->text('terms')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            $table->index('organization_id');
            $table->index('negotiation_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('counter_offers');
    }
};
