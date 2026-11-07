<?php

namespace App\Modules\Suppliers\Directory;

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
        $this->registerFilamentForPanels([
            'supplier' => [
                \App\Modules\Suppliers\Directory\Filament\Supplier\Resources\SupplierProfileResource::class,
                \App\Modules\Suppliers\Directory\Filament\Supplier\Resources\SupplierCategoryResource::class,
            ],
            'buyer' => [
                \App\Modules\Suppliers\Directory\Filament\Buyer\Resources\SupplierProfileResource::class,
                \App\Modules\Suppliers\Directory\Filament\Buyer\Resources\SupplierCategoryResource::class,
            ],
            'platform' => [
                \App\Modules\Suppliers\Directory\Filament\Platform\Resources\SupplierProfileResource::class,
                \App\Modules\Suppliers\Directory\Filament\Platform\Resources\SupplierCategoryResource::class,
            ]
        ]);
    }

    protected function registerPolicies(): void
    {
        Gate::policy(\App\Modules\Suppliers\Directory\Models\SupplierProfile::class, \App\Modules\Suppliers\Directory\Policies\SupplierProfilePolicy::class);
        Gate::policy(\App\Modules\Suppliers\Directory\Models\SupplierCategory::class, \App\Modules\Suppliers\Directory\Policies\SupplierCategoryPolicy::class);
        Gate::policy(\App\Modules\Suppliers\Directory\Models\SupplierCertification::class, \App\Modules\Suppliers\Directory\Policies\SupplierCertificationPolicy::class);
        Gate::policy(\App\Modules\Suppliers\Directory\Models\SupplierFavorite::class, \App\Modules\Suppliers\Directory\Policies\SupplierFavoritePolicy::class);
        Gate::policy(\App\Modules\Suppliers\Directory\Models\SavedSearch::class, \App\Modules\Suppliers\Directory\Policies\SavedSearchPolicy::class);
    }
}
