<?php

use App\Models\Organization;
use App\Modules\Suppliers\Catalog\Models\Product;
use App\Modules\Suppliers\Directory\Models\SupplierProfile;

it('generates unicode slugs for bangla supplier company names', function () {
    $organization = Organization::query()->create([
        'name' => 'বাংলা সাপ্লায়ার',
        'type' => 'supplier',
    ]);

    $profile = SupplierProfile::query()->withoutGlobalScope('organization')->create([
        'organization_id' => $organization->id,
        'company_name' => 'ঢাকা টেক্সটাইল মিলস',
        'country' => 'BD',
    ]);

    expect($profile->slug)->toBe('ঢাকা-টেক্সটাইল-মিলস')
        ->and($profile->slug)->not->toBeEmpty();
});

it('generates unicode slugs for bangla product names scoped per organization', function () {
    $organization = Organization::query()->create([
        'name' => 'Product Org',
        'type' => 'supplier',
    ]);

    $product = Product::query()->withoutGlobalScope('organization')->create([
        'organization_id' => $organization->id,
        'name' => 'স্টিল পাইপ ২ ইঞ্চি',
        'sku' => 'PIPE-2IN',
    ]);

    expect($product->slug)->toBe('স্টিল-পাইপ-২-ইঞ্চি');
});
