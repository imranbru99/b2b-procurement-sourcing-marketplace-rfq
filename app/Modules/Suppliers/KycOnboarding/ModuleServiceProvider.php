<?php

namespace App\Modules\Suppliers\KycOnboarding;

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
                \App\Modules\Suppliers\KycOnboarding\Filament\Supplier\Resources\KycApplicationResource::class,
            ],
            'buyer' => [
                \App\Modules\Suppliers\KycOnboarding\Filament\Buyer\Resources\KycApplicationResource::class,
            ],
            'platform' => [
                \App\Modules\Suppliers\KycOnboarding\Filament\Platform\Resources\KycApplicationResource::class,
            ]
        ]);
    }

    protected function registerPolicies(): void
    {
        Gate::policy(\App\Modules\Suppliers\KycOnboarding\Models\KycApplication::class, \App\Modules\Suppliers\KycOnboarding\Policies\KycApplicationPolicy::class);
        Gate::policy(\App\Modules\Suppliers\KycOnboarding\Models\KycDocument::class, \App\Modules\Suppliers\KycOnboarding\Policies\KycDocumentPolicy::class);
        Gate::policy(\App\Modules\Suppliers\KycOnboarding\Models\SupplierBlacklist::class, \App\Modules\Suppliers\KycOnboarding\Policies\SupplierBlacklistPolicy::class);
    }
}
