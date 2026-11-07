<?php

namespace App\Modules\Core\Organizations;

use App\Models\Organization;
use App\Modules\Core\Organizations\Policies\OrganizationPolicy;
use App\Modules\Core\Support\Concerns\BootsModuleResources;
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
        $this->bootModulePolicies([
            Organization::class => OrganizationPolicy::class,
        ]);
    }
}
