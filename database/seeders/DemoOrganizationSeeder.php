<?php

namespace Database\Seeders;

use App\Models\Organization;
use Database\Seeders\Concerns\SyncsOrganizationModules;
use Illuminate\Database\Seeder;

class DemoOrganizationSeeder extends Seeder
{
    use SyncsOrganizationModules;

    public function run(): void
    {
        $platform = $this->upsertOrganization(
            DemoContext::PLATFORM_ORG,
            'Marketplace Platform Operations',
            'platform',
            'US'
        );
        $this->syncOrganizationModules($platform, $this->platformModules());

        $buyers = [
            [DemoContext::BUYER_GARMENT, 'Apex Garment Manufacturing Ltd', 'BD', $this->buyerFullStack()],
            [DemoContext::BUYER_HOSPITAL, 'City General Hospital Procurement', 'US', $this->buyerHealthcareStack()],
            [DemoContext::BUYER_GOVERNMENT, 'National Government Procurement Office', 'GB', $this->buyerComplianceStack()],
        ];

        foreach ($buyers as [$slug, $name, $country, $modules]) {
            $org = $this->upsertOrganization($slug, $name, 'buyer', $country);
            $this->syncOrganizationModules($org, $modules);
        }

        $logistics = $this->upsertOrganization(
            DemoContext::LOGISTICS_ORG,
            'Global Freight & Logistics Partners',
            'logistics',
            'NL'
        );
        $this->syncOrganizationModules($logistics, $this->logisticsModules());

        $industries = [
            'textiles', 'medical', 'electronics', 'chemicals', 'food', 'construction',
            'automotive', 'packaging', 'furniture', 'agriculture', 'energy', 'plastics',
        ];
        $countries = ['US', 'BD', 'DE', 'CN', 'IN', 'VN', 'TR', 'MX', 'BR', 'SG', 'AE', 'PL'];

        for ($i = 1; $i <= 32; $i++) {
            $slug = DemoContext::supplierSlug($i);
            $industry = $industries[($i - 1) % count($industries)];
            $country = $countries[($i - 1) % count($countries)];
            $name = sprintf('Demo Supplier %02d (%s)', $i, ucfirst($industry));

            $org = $this->upsertOrganization($slug, $name, 'supplier', $country, [
                'industry' => $industry,
                'demo_index' => $i,
            ]);

            $moduleSet = match ($i % 4) {
                0 => $this->supplierFullStack(),
                1 => $this->supplierCatalogOnly(),
                2 => $this->supplierSalesStack(),
                default => $this->supplierKycHeavyStack(),
            };

            $this->syncOrganizationModules($org, $moduleSet);
        }
    }

    protected function upsertOrganization(
        string $slug,
        string $name,
        string $type,
        string $country,
        array $settings = []
    ): Organization {
        return Organization::query()->updateOrCreate(
            ['slug' => $slug],
            [
                'name' => $name,
                'type' => $type,
                'legal_name' => $name,
                'email' => "{$slug}@demo.test",
                'country' => $country,
                'locale' => 'en',
                'timezone' => 'UTC',
                'settings' => $settings,
                'is_active' => true,
            ]
        );
    }

    /**
     * @return list<string>
     */
    protected function coreModules(): array
    {
        return [
            'core.audit-log',
            'core.dashboard',
            'core.file-manager',
            'core.localization',
            'core.module-manager',
            'core.notifications',
            'core.organizations',
            'core.settings',
            'core.users',
        ];
    }

    /**
     * @return list<string>
     */
    protected function platformModules(): array
    {
        return array_merge($this->coreModules(), [
            'platform.api-integrations',
            'platform.cms-blog',
            'platform.data-import-export',
            'platform.helpdesk',
            'platform.multi-language-pdf',
            'platform.security-center',
            'platform.subscriptions-billing',
            'intelligence.ai-assistant',
            'intelligence.analytics',
            'intelligence.market-data',
        ]);
    }

    /**
     * @return list<string>
     */
    protected function buyerFullStack(): array
    {
        return array_merge($this->coreModules(), [
            'sourcing.purchase-requisitions',
            'sourcing.rfqs',
            'sourcing.bidding',
            'sourcing.bid-scoring',
            'sourcing.awards-contracts',
            'sourcing.negotiation',
            'sourcing.reverse-auctions',
            'sourcing.supplier-invitations',
            'orders.purchase-orders',
            'orders.goods-receipt',
            'orders.invoicing',
            'orders.payments',
            'orders.disputes',
            'operations.budgets',
            'operations.messaging',
            'intelligence.analytics',
            'marketplace.rfq',
            'marketplace.bids',
        ]);
    }

    /**
     * @return list<string>
     */
    protected function buyerHealthcareStack(): array
    {
        return array_merge($this->buyerFullStack(), [
            'operations.inspection-attendance',
            'suppliers.kyc-onboarding',
        ]);
    }

    /**
     * @return list<string>
     */
    protected function buyerComplianceStack(): array
    {
        return array_merge($this->buyerFullStack(), [
            'operations.inspection-attendance',
            'orders.escrow-wallet',
            'suppliers.risk-compliance',
        ]);
    }

    /**
     * @return list<string>
     */
    protected function logisticsModules(): array
    {
        return array_merge($this->coreModules(), [
            'operations.logistics',
            'operations.inspection-attendance',
            'orders.purchase-orders',
            'orders.goods-receipt',
        ]);
    }

    /**
     * @return list<string>
     */
    protected function supplierFullStack(): array
    {
        return array_merge($this->coreModules(), [
            'suppliers.directory',
            'suppliers.catalog',
            'suppliers.storefronts',
            'suppliers.kyc-onboarding',
            'suppliers.reviews-scorecards',
            'suppliers.risk-compliance',
            'suppliers.leads-advertising',
            'sourcing.bidding',
            'marketplace.bids',
            'marketplace.rfq',
        ]);
    }

    /**
     * @return list<string>
     */
    protected function supplierCatalogOnly(): array
    {
        return array_merge($this->coreModules(), [
            'suppliers.directory',
            'suppliers.catalog',
        ]);
    }

    /**
     * @return list<string>
     */
    protected function supplierSalesStack(): array
    {
        return array_merge($this->coreModules(), [
            'suppliers.directory',
            'suppliers.storefronts',
            'suppliers.leads-advertising',
            'sourcing.bidding',
            'marketplace.bids',
        ]);
    }

    /**
     * @return list<string>
     */
    protected function supplierKycHeavyStack(): array
    {
        return array_merge($this->coreModules(), [
            'suppliers.directory',
            'suppliers.kyc-onboarding',
            'suppliers.risk-compliance',
            'suppliers.reviews-scorecards',
        ]);
    }
}
