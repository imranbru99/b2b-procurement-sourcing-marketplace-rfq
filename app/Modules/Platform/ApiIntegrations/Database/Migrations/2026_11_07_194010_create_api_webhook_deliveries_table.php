<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('api_webhook_deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('webhook_endpoint_id')->constrained('api_webhook_endpoints')->cascadeOnDelete();
            $table->string('event');
            $table->json('payload')->nullable();
            $table->string('status')->default('pending');
            $table->unsignedSmallInteger('response_code')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('api_webhook_deliveries');
    }
};
