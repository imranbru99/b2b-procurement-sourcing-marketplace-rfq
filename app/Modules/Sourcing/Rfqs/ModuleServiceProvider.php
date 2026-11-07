<?php

namespace App\Modules\Sourcing\Rfqs;

use App\Modules\Sourcing\Concerns\BootsModuleResources;
use App\Modules\Sourcing\Rfqs\Filament\Buyer\Resources\RfqResource;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use App\Modules\Sourcing\Rfqs\Policies\RfqPolicy;
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
            Rfq::class => RfqPolicy::class,
        ]);
        $this->registerBuyerFilamentResources([
            RfqResource::class,
        ]);
    }
}
