<?php

namespace App\Modules\Orders\PurchaseOrders;

use App\Modules\Orders\Concerns\BootsModuleResources;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    use BootsModuleResources;

    public function register(): void
    {
        
    }

    public function boot(): void
    {
        $this->bootModuleMigrations();

        $policies = array (
  'App\\Modules\\Orders\\PurchaseOrders\\Models\\PurchaseOrder' => 'App\\Modules\\Orders\\PurchaseOrders\\Policies\\PurchaseOrderPolicy',
  'App\\Modules\\Orders\\PurchaseOrders\\Models\\PoItem' => 'App\\Modules\\Orders\\PurchaseOrders\\Policies\\PoItemPolicy',
  'App\\Modules\\Orders\\PurchaseOrders\\Models\\PoRevision' => 'App\\Modules\\Orders\\PurchaseOrders\\Policies\\PoRevisionPolicy',
  'App\\Modules\\Orders\\PurchaseOrders\\Models\\PoAcknowledgment' => 'App\\Modules\\Orders\\PurchaseOrders\\Policies\\PoAcknowledgmentPolicy',
);

        $this->bootModulePolicies($policies);

        $this->registerBuyerFilamentResources([
            \App\Modules\Orders\PurchaseOrders\Filament\Resources\PurchaseOrderResource::class,
        ]);
    }
}
