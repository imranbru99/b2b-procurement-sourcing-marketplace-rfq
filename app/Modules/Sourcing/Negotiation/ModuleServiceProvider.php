<?php

namespace App\Modules\Sourcing\Negotiation;

use App\Modules\Sourcing\Concerns\BootsModuleResources;
use App\Modules\Sourcing\Negotiation\Models\Negotiation;
use App\Modules\Sourcing\Negotiation\Policies\NegotiationPolicy;
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
            Negotiation::class => NegotiationPolicy::class,
        ]);
    }
}
