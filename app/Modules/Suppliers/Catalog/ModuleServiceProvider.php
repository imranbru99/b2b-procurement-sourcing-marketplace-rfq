<?php

namespace App\Modules\Suppliers\Catalog;

use App\Modules\Suppliers\Support\Concerns\RegistersFilamentResources;
use App\Modules\Suppliers\Support\Concerns\RegistersModuleMigrations;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    use RegistersFilamentResources, RegistersModuleMigrations;

    public function register(): void
    {
        $this->app->singleton(Services\ProductBulkImportService::class);
    }

    public function boot(): void
    {
        $this->loadModuleMigrations();
        $this->registerPolicies();
        $this->registerFilamentForPanels([
            'supplier' => [
                \App\Modules\Suppliers\Catalog\Filament\Supplier\Resources\ProductResource::class,
            ],
            'buyer' => [
                \App\Modules\Suppliers\Catalog\Filament\Buyer\Resources\ProductResource::class,
            ],
            'platform' => [
                \App\Modules\Suppliers\Catalog\Filament\Platform\Resources\ProductResource::class,
            ]
        ]);
    }

    protected function registerPolicies(): void
    {
        Gate::policy(\App\Modules\Suppliers\Catalog\Models\Product::class, \App\Modules\Suppliers\Catalog\Policies\ProductPolicy::class);
        Gate::policy(\App\Modules\Suppliers\Catalog\Models\ProductPriceTier::class, \App\Modules\Suppliers\Catalog\Policies\ProductPriceTierPolicy::class);
        Gate::policy(\App\Modules\Suppliers\Catalog\Models\ProductSpecialPrice::class, \App\Modules\Suppliers\Catalog\Policies\ProductSpecialPricePolicy::class);
    }
}
