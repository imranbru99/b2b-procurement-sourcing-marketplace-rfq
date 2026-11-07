<?php

namespace App\Modules\Orders\Disputes;

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
  'App\\Modules\\Orders\\Disputes\\Models\\Dispute' => 'App\\Modules\\Orders\\Disputes\\Policies\\DisputePolicy',
  'App\\Modules\\Orders\\Disputes\\Models\\DisputeEvidence' => 'App\\Modules\\Orders\\Disputes\\Policies\\DisputeEvidencePolicy',
  'App\\Modules\\Orders\\Disputes\\Models\\DisputeResolution' => 'App\\Modules\\Orders\\Disputes\\Policies\\DisputeResolutionPolicy',
);

        $this->bootModulePolicies($policies);

        $this->registerBuyerFilamentResources([
            \App\Modules\Orders\Disputes\Filament\Resources\DisputeResource::class,
        ]);
    }
}
