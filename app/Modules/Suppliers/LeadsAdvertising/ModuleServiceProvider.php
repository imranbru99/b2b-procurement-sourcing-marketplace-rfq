<?php

namespace App\Modules\Suppliers\LeadsAdvertising;

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
                \App\Modules\Suppliers\LeadsAdvertising\Filament\Supplier\Resources\SponsoredListingResource::class,
            ],
            'buyer' => [
                \App\Modules\Suppliers\LeadsAdvertising\Filament\Buyer\Resources\SponsoredListingResource::class,
            ],
            'platform' => [
                \App\Modules\Suppliers\LeadsAdvertising\Filament\Platform\Resources\SponsoredListingResource::class,
            ]
        ]);
    }

    protected function registerPolicies(): void
    {
        Gate::policy(\App\Modules\Suppliers\LeadsAdvertising\Models\SponsoredListing::class, \App\Modules\Suppliers\LeadsAdvertising\Policies\SponsoredListingPolicy::class);
        Gate::policy(\App\Modules\Suppliers\LeadsAdvertising\Models\FeaturedSupplier::class, \App\Modules\Suppliers\LeadsAdvertising\Policies\FeaturedSupplierPolicy::class);
        Gate::policy(\App\Modules\Suppliers\LeadsAdvertising\Models\LeadUnlock::class, \App\Modules\Suppliers\LeadsAdvertising\Policies\LeadUnlockPolicy::class);
        Gate::policy(\App\Modules\Suppliers\LeadsAdvertising\Models\AdvertisingCoupon::class, \App\Modules\Suppliers\LeadsAdvertising\Policies\AdvertisingCouponPolicy::class);
    }
}
