<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rfqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('purchase_requisition_id')->nullable()->constrained()->nullOnDelete();
            $table->string('type', 8)->default('rfq');
            $table->string('title');
            $table->string('slug');
            $table->string('visibility', 16)->default('private');
            $table->string('status', 16)->default('draft');
            $table->timestamp('deadline')->nullable();
            $table->string('incoterms', 16)->nullable();
            $table->string('payment_terms')->nullable();
            $table->string('delivery_terms')->nullable();
            $table->unsignedInteger('version')->default(1);
            $table->foreignId('parent_id')->nullable()->constrained('rfqs')->nullOnDelete();
            $table->timestamps();

            $table->unique(['organization_id', 'slug']);
            $table->index('organization_id');
            $table->index(['organization_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rfqs');
    }
};
