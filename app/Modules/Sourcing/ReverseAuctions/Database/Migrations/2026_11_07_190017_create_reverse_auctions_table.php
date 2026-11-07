<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reverse_auctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('rfq_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('status', 16)->default('scheduled');
            $table->decimal('starting_price', 15, 2)->default(0);
            $table->decimal('current_price', 15, 2)->default(0);
            $table->decimal('decrement', 15, 2)->default(0);
            $table->unsignedSmallInteger('auto_extend_minutes')->default(5);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->string('currency', 3)->default('USD');
            $table->timestamps();

            $table->index('organization_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reverse_auctions');
    }
};
