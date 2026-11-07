<?php

namespace App\Modules\Sourcing\PurchaseRequisitions;

use App\Modules\Sourcing\Concerns\BootsModuleResources;
use App\Modules\Sourcing\PurchaseRequisitions\Filament\Buyer\Resources\PurchaseRequisitionResource;
use App\Modules\Sourcing\PurchaseRequisitions\Models\PurchaseRequisition;
use App\Modules\Sourcing\PurchaseRequisitions\Policies\PurchaseRequisitionPolicy;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    use BootsModuleResources;

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->bootModuleMigrations();
        $this->bootModulePolicies([
            PurchaseRequisition::class => PurchaseRequisitionPolicy::class,
        ]);
        $this->registerBuyerFilamentResources([
            PurchaseRequisitionResource::class,
        ]);
    }
}
