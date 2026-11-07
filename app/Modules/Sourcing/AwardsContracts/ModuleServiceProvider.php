<?php

namespace App\Modules\Sourcing\AwardsContracts;

use App\Modules\Sourcing\AwardsContracts\Filament\Buyer\Resources\AwardResource;
use App\Modules\Sourcing\AwardsContracts\Models\Award;
use App\Modules\Sourcing\AwardsContracts\Models\Contract;
use App\Modules\Sourcing\AwardsContracts\Policies\AwardPolicy;
use App\Modules\Sourcing\AwardsContracts\Policies\ContractPolicy;
use App\Modules\Sourcing\AwardsContracts\Services\RfqAwardWorkflow;
use App\Modules\Sourcing\Concerns\BootsModuleResources;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    use BootsModuleResources;

    public function register(): void
    {
        $this->app->singleton(RfqAwardWorkflow::class);
    }

    public function boot(): void
    {
        $this->bootModuleMigrations();
        $this->bootModulePolicies([
            Award::class => AwardPolicy::class,
            Contract::class => ContractPolicy::class,
        ]);
        $this->registerBuyerFilamentResources([
            AwardResource::class,
        ]);
    }
}
