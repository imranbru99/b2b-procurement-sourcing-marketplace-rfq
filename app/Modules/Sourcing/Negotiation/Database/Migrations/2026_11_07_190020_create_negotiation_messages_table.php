<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('negotiation_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('negotiation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sender_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('sender_organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->text('body');
            $table->timestamps();

            $table->index('organization_id');
            $table->index('negotiation_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('negotiation_messages');
    }
};
