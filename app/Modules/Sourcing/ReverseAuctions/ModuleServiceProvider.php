<?php

namespace App\Modules\Sourcing\ReverseAuctions;

use App\Modules\Sourcing\Concerns\BootsModuleResources;
use App\Modules\Sourcing\ReverseAuctions\Models\ReverseAuction;
use App\Modules\Sourcing\ReverseAuctions\Policies\ReverseAuctionPolicy;
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
            ReverseAuction::class => ReverseAuctionPolicy::class,
        ]);
    }
}
