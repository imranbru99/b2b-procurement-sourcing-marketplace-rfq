<?php

declare(strict_types=1);

$root = dirname(__DIR__);

$modules = [
    'Directory' => [
        'models' => ['SupplierProfile', 'SupplierCategory', 'SupplierCertification', 'SupplierFavorite', 'SavedSearch'],
        'filament' => ['SupplierProfile', 'SupplierCategory'],
    ],
    'Storefronts' => [
        'models' => ['SupplierStorefront', 'PortfolioItem', 'SupplierFactory', 'SupplierVideo', 'SupplierDownload'],
        'filament' => [],
    ],
    'Catalog' => [
        'models' => ['Product', 'ProductPriceTier', 'ProductSpecialPrice'],
        'filament' => ['Product'],
    ],
    'KycOnboarding' => [
        'models' => ['KycApplication', 'KycDocument', 'SupplierBlacklist'],
        'filament' => ['KycApplication'],
    ],
    'ReviewsScorecards' => [
        'models' => ['SupplierReview', 'VendorKpi', 'VendorScorecard'],
        'filament' => ['SupplierReview'],
    ],
    'RiskCompliance' => [
        'models' => ['RiskScore', 'ComplianceDocument', 'EsgQuestionnaire', 'ApprovedVendorList'],
        'filament' => ['RiskScore'],
    ],
    'LeadsAdvertising' => [
        'models' => ['SponsoredListing', 'FeaturedSupplier', 'LeadUnlock', 'AdvertisingCoupon'],
        'filament' => ['SponsoredListing'],
    ],
];

foreach ($modules as $module => $config) {
    $policyLines = [];
    foreach ($config['models'] as $model) {
        $policyLines[] = "        Gate::policy(\\App\\Modules\\Suppliers\\$module\\Models\\$model::class, \\App\\Modules\\Suppliers\\$module\\Policies\\{$model}Policy::class);";
    }

    $panels = ['supplier' => 'Supplier', 'buyer' => 'Buyer', 'platform' => 'Platform'];
    $filamentEntries = [];
    foreach ($panels as $panelId => $panelDir) {
        $resources = [];
        foreach ($config['filament'] as $model) {
            $resources[] = "\\App\\Modules\\Suppliers\\$module\\Filament\\$panelDir\\Resources\\{$model}Resource::class";
        }
        if ($resources !== []) {
            $filamentEntries[] = "            '$panelId' => [\n                ".implode(",\n                ", $resources).",\n            ]";
        }
    }

    $filamentBlock = $filamentEntries === []
        ? ''
        : "\n        \$this->registerFilamentForPanels([\n".implode(",\n", $filamentEntries)."\n        ]);";

    $provider = <<<PHP
<?php

namespace App\\Modules\\Suppliers\\$module;

use App\\Modules\\Suppliers\\Support\\Concerns\\RegistersFilamentResources;
use App\\Modules\\Suppliers\\Support\\Concerns\\RegistersModuleMigrations;
use Illuminate\\Support\\Facades\\Gate;
use Illuminate\\Support\\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    use RegistersFilamentResources, RegistersModuleMigrations;

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        \$this->loadModuleMigrations();
        \$this->registerPolicies();{$filamentBlock}
    }

    protected function registerPolicies(): void
    {
{POLICIES}
    }
}

PHP;

    $provider = str_replace('{POLICIES}', implode("\n", $policyLines), $provider);
    file_put_contents("$root/app/Modules/Suppliers/$module/ModuleServiceProvider.php", $provider);
}

echo "Updated ModuleServiceProviders.\n";
