<?php

namespace Database\Seeders;

use App\Models\User;
use App\Modules\Suppliers\Catalog\Models\Product;
use App\Modules\Suppliers\Directory\Models\SupplierCategory;
use App\Modules\Suppliers\Directory\Models\SupplierCertification;
use App\Modules\Suppliers\Directory\Models\SupplierProfile;
use App\Modules\Suppliers\KycOnboarding\Models\KycApplication;
use App\Modules\Suppliers\ReviewsScorecards\Models\SupplierReview;
use Illuminate\Database\Seeder;

class DemoSupplierSeeder extends Seeder
{
    public function run(): void
    {
        $category = SupplierCategory::query()->updateOrCreate(
            ['slug' => 'demo-industrial-supplies'],
            [
                'name' => 'Industrial supplies',
                'description' => 'Demo category for seeded suppliers.',
                'parent_id' => null,
                'is_active' => true,
            ]
        );

        SupplierCategory::query()->updateOrCreate(
            ['slug' => 'demo-medical-consumables'],
            [
                'name' => 'Medical consumables',
                'description' => 'Healthcare procurement category.',
                'parent_id' => $category->id,
                'is_active' => true,
            ]
        );

        $buyerUser = User::query()->where('email', 'buyer.admin@demo.test')->first();

        for ($i = 1; $i <= 8; $i++) {
            $org = DemoContext::organization(DemoContext::supplierSlug($i));

            $profile = SupplierProfile::query()->updateOrCreate(
                ['organization_id' => $org->id],
                [
                    'company_name' => $org->name,
                    'slug' => $org->slug,
                    'tagline' => "Trusted supplier #{$i} on the demo marketplace",
                    'description' => 'Seeded supplier profile with catalog, certifications, and reviews.',
                    'country' => $org->country,
                    'website' => 'https://example.test',
                    'employee_count' => 50 + ($i * 10),
                    'year_founded' => 2000 + $i,
                    'verified_at' => $i <= 5 ? now()->subMonths(2) : null,
                ]
            );

            SupplierCertification::query()->updateOrCreate(
                [
                    'supplier_profile_id' => $profile->id,
                    'name' => 'ISO 9001',
                ],
                [
                    'issuing_body' => 'Demo Certification Body',
                    'issued_at' => now()->subYears(2),
                    'expires_at' => now()->addYears(1),
                ]
            );

            Product::query()->updateOrCreate(
                [
                    'organization_id' => $org->id,
                    'sku' => "DEMO-SKU-{$i}-001",
                ],
                [
                    'supplier_profile_id' => $profile->id,
                    'name' => "Demo product {$i}",
                    'slug' => "demo-product-{$i}",
                    'description' => 'Catalog item for supplier discovery demos.',
                    'price' => 25.5 + $i,
                    'currency' => 'USD',
                    'moq' => 10,
                    'is_active' => true,
                ]
            );

            if ($buyerUser) {
                SupplierReview::query()->updateOrCreate(
                    [
                        'supplier_profile_id' => $profile->id,
                        'buyer_organization_id' => DemoContext::organization(DemoContext::BUYER_GARMENT)->id,
                        'author_id' => $buyerUser->id,
                    ],
                    [
                        'rating' => min(5, 3 + ($i % 3)),
                        'title' => 'Reliable demo supplier',
                        'body' => 'Seeded review for marketplace trust signals.',
                        'is_published' => true,
                    ]
                );
            }

            KycApplication::query()->updateOrCreate(
                ['organization_id' => $org->id],
                [
                    'supplier_profile_id' => $profile->id,
                    'status' => $i <= 4 ? 'approved' : ($i <= 6 ? 'pending' : 'submitted'),
                    'submitted_at' => now()->subDays(10 - $i),
                    'reviewed_at' => $i <= 4 ? now()->subDays(3) : null,
                ]
            );
        }
    }
}
