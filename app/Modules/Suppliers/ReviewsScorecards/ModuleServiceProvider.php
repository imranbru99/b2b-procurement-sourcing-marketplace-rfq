<?php

namespace App\Modules\Suppliers\ReviewsScorecards;

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
                \App\Modules\Suppliers\ReviewsScorecards\Filament\Supplier\Resources\SupplierReviewResource::class,
            ],
            'buyer' => [
                \App\Modules\Suppliers\ReviewsScorecards\Filament\Buyer\Resources\SupplierReviewResource::class,
            ],
            'platform' => [
                \App\Modules\Suppliers\ReviewsScorecards\Filament\Platform\Resources\SupplierReviewResource::class,
            ]
        ]);
    }

    protected function registerPolicies(): void
    {
        Gate::policy(\App\Modules\Suppliers\ReviewsScorecards\Models\SupplierReview::class, \App\Modules\Suppliers\ReviewsScorecards\Policies\SupplierReviewPolicy::class);
        Gate::policy(\App\Modules\Suppliers\ReviewsScorecards\Models\VendorKpi::class, \App\Modules\Suppliers\ReviewsScorecards\Policies\VendorKpiPolicy::class);
        Gate::policy(\App\Modules\Suppliers\ReviewsScorecards\Models\VendorScorecard::class, \App\Modules\Suppliers\ReviewsScorecards\Policies\VendorScorecardPolicy::class);
    }
}
