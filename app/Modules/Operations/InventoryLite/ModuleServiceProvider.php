<?php

namespace App\Modules\Operations\InventoryLite;

use App\Modules\Operations\Concerns\BootsModuleResources;
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
  'App\\Modules\\Operations\\InventoryLite\\Models\\InventoryItem' => 'App\\Modules\\Operations\\InventoryLite\\Policies\\InventoryItemPolicy',
  'App\\Modules\\Operations\\InventoryLite\\Models\\StockLevel' => 'App\\Modules\\Operations\\InventoryLite\\Policies\\StockLevelPolicy',
  'App\\Modules\\Operations\\InventoryLite\\Models\\ReorderPoint' => 'App\\Modules\\Operations\\InventoryLite\\Policies\\ReorderPointPolicy',
);

        $this->bootModulePolicies($policies);

        $this->registerBuyerFilamentResources([
            \App\Modules\Operations\InventoryLite\Filament\Resources\InventoryItemResource::class,
        ]);
    }
}
