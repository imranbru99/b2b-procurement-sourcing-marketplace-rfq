<?php

namespace App\Modules\Operations\Budgets;

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
  'App\\Modules\\Operations\\Budgets\\Models\\CostCenter' => 'App\\Modules\\Operations\\Budgets\\Policies\\CostCenterPolicy',
  'App\\Modules\\Operations\\Budgets\\Models\\Budget' => 'App\\Modules\\Operations\\Budgets\\Policies\\BudgetPolicy',
  'App\\Modules\\Operations\\Budgets\\Models\\BudgetAlert' => 'App\\Modules\\Operations\\Budgets\\Policies\\BudgetAlertPolicy',
);

        $this->bootModulePolicies($policies);

        $this->registerBuyerFilamentResources([
            \App\Modules\Operations\Budgets\Filament\Resources\BudgetResource::class,
        ]);
    }
}
