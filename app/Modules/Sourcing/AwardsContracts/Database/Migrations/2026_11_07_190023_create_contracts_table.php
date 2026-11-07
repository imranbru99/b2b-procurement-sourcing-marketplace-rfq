<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->foreignId('award_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('supplier_organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->string('title');
            $table->string('slug');
            $table->string('template_key')->nullable();
            $table->string('status', 16)->default('draft');
            $table->string('e_sign_status', 16)->default('unsigned');
            $table->timestamp('signed_at')->nullable();
            $table->timestamp('effective_from')->nullable();
            $table->timestamp('effective_until')->nullable();
            $table->decimal('contract_value', 15, 2)->default(0);
            $table->string('currency', 3)->default('USD');
            $table->timestamps();

            $table->unique(['organization_id', 'slug']);
            $table->index('organization_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
