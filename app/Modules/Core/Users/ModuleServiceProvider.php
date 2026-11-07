<?php

namespace App\Modules\Core\Users;

use App\Models\User;
use App\Modules\Core\Support\Concerns\BootsModuleResources;
use App\Modules\Core\Users\Policies\UserPolicy;
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
            User::class => UserPolicy::class,
        ]);
    }
}
