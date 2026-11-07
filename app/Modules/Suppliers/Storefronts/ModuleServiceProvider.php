<?php

namespace App\Modules\Suppliers\Storefronts;

use App\Modules\Suppliers\Support\Concerns\RegistersFilamentResources;
use App\Modules\Suppliers\Support\Concerns\RegistersModuleMigrations;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    use RegistersFilamentResources, RegistersModuleMigrations;

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadModuleMigrations();
        $this->registerPolicies();
    }

    protected function registerPolicies(): void
    {
        Gate::policy(\App\Modules\Suppliers\Storefronts\Models\SupplierStorefront::class, \App\Modules\Suppliers\Storefronts\Policies\SupplierStorefrontPolicy::class);
        Gate::policy(\App\Modules\Suppliers\Storefronts\Models\PortfolioItem::class, \App\Modules\Suppliers\Storefronts\Policies\PortfolioItemPolicy::class);
        Gate::policy(\App\Modules\Suppliers\Storefronts\Models\SupplierFactory::class, \App\Modules\Suppliers\Storefronts\Policies\SupplierFactoryPolicy::class);
        Gate::policy(\App\Modules\Suppliers\Storefronts\Models\SupplierVideo::class, \App\Modules\Suppliers\Storefronts\Policies\SupplierVideoPolicy::class);
        Gate::policy(\App\Modules\Suppliers\Storefronts\Models\SupplierDownload::class, \App\Modules\Suppliers\Storefronts\Policies\SupplierDownloadPolicy::class);
    }
}
