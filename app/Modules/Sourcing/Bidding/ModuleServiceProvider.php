<?php

namespace App\Modules\Sourcing\Bidding;

use App\Modules\Sourcing\Bidding\Models\Bid;
use App\Modules\Sourcing\Bidding\Policies\BidPolicy;
use App\Modules\Sourcing\Concerns\BootsModuleResources;
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
            Bid::class => BidPolicy::class,
        ]);
    }
}
