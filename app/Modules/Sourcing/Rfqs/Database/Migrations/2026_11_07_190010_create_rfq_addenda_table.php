<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rfq_addenda', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('rfq_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('body');
            $table->unsignedInteger('addendum_number')->default(1);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();

            $table->index('organization_id');
            $table->index('rfq_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rfq_addenda');
    }
};
