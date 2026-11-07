<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_profile_id')->constrained('supplier_profiles')->cascadeOnDelete();
            $table->foreignId('buyer_organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->foreignId('author_id')->nullable()->constrained('users')->nullOnDelete();
            $table->unsignedBigInteger('purchase_order_id')->nullable();
            $table->unsignedTinyInteger('rating');
            $table->string('title')->nullable();
            $table->text('body')->nullable();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('vendor_kpis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_profile_id')->constrained('supplier_profiles')->cascadeOnDelete();
            $table->string('metric_key');
            $table->decimal('value', 12, 4);
            $table->string('period')->nullable();
            $table->date('recorded_on')->nullable();
            $table->timestamps();

            $table->index(['supplier_profile_id', 'metric_key']);
        });

        Schema::create('vendor_scorecards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_profile_id')->constrained('supplier_profiles')->cascadeOnDelete();
            $table->foreignId('buyer_organization_id')->nullable()->constrained('organizations')->nullOnDelete();
            $table->string('period_label');
            $table->decimal('overall_score', 5, 2)->default(0);
            $table->json('dimensions')->nullable();
            $table->text('summary')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vendor_scorecards');
        Schema::dropIfExists('vendor_kpis');
        Schema::dropIfExists('supplier_reviews');
    }
};
