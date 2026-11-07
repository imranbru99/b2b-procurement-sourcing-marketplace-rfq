<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sponsored_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_profile_id')->constrained('supplier_profiles')->cascadeOnDelete();
            $table->foreignId('supplier_category_id')->nullable()->constrained('supplier_categories')->nullOnDelete();
            $table->unsignedInteger('impressions')->default(0);
            $table->unsignedInteger('clicks')->default(0);
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('featured_suppliers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_profile_id')->constrained('supplier_profiles')->cascadeOnDelete();
            $table->string('placement')->default('homepage');
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamp('featured_from')->nullable();
            $table->timestamp('featured_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('lead_unlocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('buyer_organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->foreignId('supplier_profile_id')->constrained('supplier_profiles')->cascadeOnDelete();
            $table->foreignId('unlocked_by')->nullable()->constrained('users')->nullOnDelete();
            $table->decimal('credits_spent', 10, 2)->default(0);
            $table->timestamp('unlocked_at');
            $table->timestamps();

            $table->unique(['buyer_organization_id', 'supplier_profile_id'], 'lead_unlocks_unique');
        });

        Schema::create('advertising_coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->decimal('discount_percent', 5, 2)->nullable();
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->unsignedInteger('max_redemptions')->nullable();
            $table->unsignedInteger('redemptions_count')->default(0);
            $table->timestamp('valid_from')->nullable();
            $table->timestamp('valid_until')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advertising_coupons');
        Schema::dropIfExists('lead_unlocks');
        Schema::dropIfExists('featured_suppliers');
        Schema::dropIfExists('sponsored_listings');
    }
};
