<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('negotiations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('rfq_id')->constrained()->cascadeOnDelete();
            $table->foreignId('bid_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('supplier_organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->string('status', 16)->default('open');
            $table->string('subject')->nullable();
            $table->timestamps();

            $table->index('organization_id');
            $table->index('rfq_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('negotiations');
    }
};
