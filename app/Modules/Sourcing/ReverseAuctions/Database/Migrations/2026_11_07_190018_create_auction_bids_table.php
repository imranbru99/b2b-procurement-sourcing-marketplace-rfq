<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auction_bids', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reverse_auction_id')->constrained()->cascadeOnDelete();
            $table->foreignId('supplier_organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->decimal('amount', 15, 2);
            $table->boolean('is_winning')->default(false);
            $table->timestamp('placed_at')->nullable();
            $table->timestamps();

            $table->index('organization_id');
            $table->index('reverse_auction_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auction_bids');
    }
};
