<?php

namespace App\Modules\Orders\Invoicing;

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
  'App\\Modules\\Orders\\Invoicing\\Models\\Invoice' => 'App\\Modules\\Orders\\Invoicing\\Policies\\InvoicePolicy',
  'App\\Modules\\Orders\\Invoicing\\Models\\InvoiceItem' => 'App\\Modules\\Orders\\Invoicing\\Policies\\InvoiceItemPolicy',
  'App\\Modules\\Orders\\Invoicing\\Models\\CreditNote' => 'App\\Modules\\Orders\\Invoicing\\Policies\\CreditNotePolicy',
);

        $this->bootModulePolicies($policies);

        $this->registerBuyerFilamentResources([
            \App\Modules\Orders\Invoicing\Filament\Resources\InvoiceResource::class,
        ]);
    }
}
