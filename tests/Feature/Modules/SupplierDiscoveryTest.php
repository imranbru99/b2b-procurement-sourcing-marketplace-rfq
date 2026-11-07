<?php

use App\Models\Organization;
use App\Modules\ModuleRegistry;
use App\Modules\Suppliers\Catalog\Models\Product;
use App\Modules\Suppliers\Catalog\Services\ProductBulkImportService;
use App\Modules\Suppliers\Directory\Models\SupplierCategory;
use App\Modules\Suppliers\Directory\Models\SupplierProfile;

it('registers all supplier discovery modules', function () {
    $keys = app(ModuleRegistry::class)->keys();

    expect($keys)->toContain(
        'suppliers.directory',
        'suppliers.storefronts',
        'suppliers.catalog',
        'suppliers.kyc-onboarding',
        'suppliers.reviews-scorecards',
        'suppliers.risk-compliance',
        'suppliers.leads-advertising',
    );
});

it('creates supplier profiles with hierarchical categories', function () {
    $organization = Organization::query()->create([
        'name' => 'FabTex Ltd',
        'type' => 'supplier',
    ]);

    $parent = SupplierCategory::query()->create([
        'name' => 'Textiles',
        'slug' => 'textiles',
        'code' => '50',
        'depth' => 0,
    ]);

    $child = SupplierCategory::query()->create([
        'parent_id' => $parent->id,
        'name' => 'Woven Fabrics',
        'slug' => 'woven-fabrics',
        'code' => '5010',
        'depth' => 1,
    ]);

    $profile = SupplierProfile::query()->withoutGlobalScope('organization')->create([
        'organization_id' => $organization->id,
        'company_name' => 'FabTex Export',
        'country' => 'BD',
        'city' => 'Dhaka',
    ]);

    $profile->categories()->attach($child->id, ['is_primary' => true]);

    expect($profile->fresh()->categories)->toHaveCount(1)
        ->and($profile->categories->first()->parent_id)->toBe($parent->id);
});

it('imports catalog rows in bulk', function () {
    $organization = Organization::query()->create([
        'name' => 'Catalog Co',
        'type' => 'supplier',
    ]);

    $result = app(ProductBulkImportService::class)->import($organization->id, [
        ['name' => 'Bolt M8', 'sku' => 'M8-001', 'price' => 12.5],
        ['name' => 'Bolt M8', 'sku' => 'M8-001', 'price' => 13.0],
    ]);

    expect($result['created'])->toBe(1)
        ->and($result['updated'])->toBe(1)
        ->and(Product::query()->withoutGlobalScope('organization')->where('organization_id', $organization->id)->count())->toBe(1);
});
