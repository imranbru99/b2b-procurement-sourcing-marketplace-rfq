<?php

namespace App\Modules\Orders\GoodsReceipt;

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
  'App\\Modules\\Orders\\GoodsReceipt\\Models\\Grn' => 'App\\Modules\\Orders\\GoodsReceipt\\Policies\\GrnPolicy',
  'App\\Modules\\Orders\\GoodsReceipt\\Models\\GrnItem' => 'App\\Modules\\Orders\\GoodsReceipt\\Policies\\GrnItemPolicy',
  'App\\Modules\\Orders\\GoodsReceipt\\Models\\QcInspection' => 'App\\Modules\\Orders\\GoodsReceipt\\Policies\\QcInspectionPolicy',
  'App\\Modules\\Orders\\GoodsReceipt\\Models\\GoodsReturn' => 'App\\Modules\\Orders\\GoodsReceipt\\Policies\\GoodsReturnPolicy',
);

        $this->bootModulePolicies($policies);

        $this->registerBuyerFilamentResources([
            \App\Modules\Orders\GoodsReceipt\Filament\Resources\GrnResource::class,
        ]);
    }
}
