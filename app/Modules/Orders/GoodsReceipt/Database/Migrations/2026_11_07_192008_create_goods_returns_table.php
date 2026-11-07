<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goods_returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('grn_id')->constrained('grns')->cascadeOnDelete();
            $table->string('reason')->nullable();
            $table->string('status', 32)->default('open');
            $table->decimal('quantity', 12, 3)->default(0);
            $table->timestamps();

            $table->index('organization_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goods_returns');
    }
};
