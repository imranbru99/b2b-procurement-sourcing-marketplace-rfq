<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('risk_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_profile_id')->constrained('supplier_profiles')->cascadeOnDelete();
            $table->decimal('score', 5, 2);
            $table->string('risk_band')->nullable();
            $table->json('factors')->nullable();
            $table->timestamp('assessed_at');
            $table->timestamps();
        });

        Schema::create('compliance_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_profile_id')->constrained('supplier_profiles')->cascadeOnDelete();
            $table->string('document_type');
            $table->string('status')->default('active');
            $table->date('expires_at')->nullable();
            $table->timestamps();
        });

        Schema::create('esg_questionnaires', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_profile_id')->constrained('supplier_profiles')->cascadeOnDelete();
            $table->string('framework')->default('generic');
            $table->json('responses');
            $table->decimal('esg_score', 5, 2)->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
        });

        Schema::create('approved_vendor_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->foreignId('supplier_profile_id')->constrained('supplier_profiles')->cascadeOnDelete();
            $table->string('status')->default('approved');
            $table->date('approved_until')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['buyer_organization_id', 'supplier_profile_id'], 'avl_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approved_vendor_lists');
        Schema::dropIfExists('esg_questionnaires');
        Schema::dropIfExists('compliance_documents');
        Schema::dropIfExists('risk_scores');
    }
};
