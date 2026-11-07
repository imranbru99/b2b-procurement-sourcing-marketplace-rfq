<?php

namespace App\Modules\Intelligence\MarketDataCatalog;

use App\Modules\Intelligence\Support\Concerns\BootsModuleResources;
use App\Services\Packages\AiCatalogService;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    use BootsModuleResources;

    public function register(): void
    {
        $this->app->singleton(AiCatalogService::class);
    }

    public function boot(): void
    {
        $this->bootModuleMigrations();

        $this->bootModulePolicies([
            \App\Modules\Intelligence\MarketDataCatalog\Models\ScrapedCatalogItem::class => \App\Modules\Intelligence\MarketDataCatalog\Policies\ScrapedCatalogItemPolicy::class,
            \App\Modules\Intelligence\MarketDataCatalog\Models\PriceBenchmark::class => \App\Modules\Intelligence\MarketDataCatalog\Policies\PriceBenchmarkPolicy::class,
        ]);

        $this->registerBuyerFilamentResources([
            \App\Modules\Intelligence\MarketDataCatalog\Filament\Resources\ScrapedCatalogItemResource::class,
        ]);
    }
}
