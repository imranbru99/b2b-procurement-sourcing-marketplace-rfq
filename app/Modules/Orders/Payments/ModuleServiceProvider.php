<?php

namespace App\Modules\Orders\Payments;

use App\Modules\Orders\Concerns\BootsModuleResources;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    use BootsModuleResources;

    public function register(): void
    {
        foreach ([
            \App\Modules\Orders\Payments\Contracts\PaymentGatewayAdapterInterface::class => \App\Modules\Orders\Payments\Services\PaymentGatewayManager::class,
        ] as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }

        $this->app->singleton(\App\Modules\Orders\Payments\Services\PaymentService::class);
        $this->app->singleton(\App\Modules\Orders\Services\OrderWorkflowService::class);
    }

    public function boot(): void
    {
        $this->bootModuleMigrations();

        $policies = array (
  'App\\Modules\\Orders\\Payments\\Models\\Payment' => 'App\\Modules\\Orders\\Payments\\Policies\\PaymentPolicy',
  'App\\Modules\\Orders\\Payments\\Models\\PaymentSchedule' => 'App\\Modules\\Orders\\Payments\\Policies\\PaymentSchedulePolicy',
  'App\\Modules\\Orders\\Payments\\Models\\PaymentProof' => 'App\\Modules\\Orders\\Payments\\Policies\\PaymentProofPolicy',
  'App\\Modules\\Orders\\Payments\\Models\\GatewayTransaction' => 'App\\Modules\\Orders\\Payments\\Policies\\GatewayTransactionPolicy',
);

        $this->bootModulePolicies($policies);

        $this->registerBuyerFilamentResources([
            \App\Modules\Orders\Payments\Filament\Resources\PaymentResource::class,
        ]);
    }
}
