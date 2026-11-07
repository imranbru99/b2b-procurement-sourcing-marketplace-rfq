<?php

namespace App\Modules\Sourcing\SupplierInvitations;

use App\Modules\Sourcing\Concerns\BootsModuleResources;
use App\Modules\Sourcing\SupplierInvitations\Models\SupplierBroadcastProfile;
use App\Modules\Sourcing\SupplierInvitations\Policies\SupplierBroadcastProfilePolicy;
use App\Modules\Sourcing\SupplierInvitations\Services\SupplierBroadcastMatchingService;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    use BootsModuleResources;

    public function register(): void
    {
        $this->app->singleton(SupplierBroadcastMatchingService::class);
    }

    public function boot(): void
    {
        $this->bootModuleMigrations();
        $this->bootModulePolicies([
            SupplierBroadcastProfile::class => SupplierBroadcastProfilePolicy::class,
        ]);
    }
}
