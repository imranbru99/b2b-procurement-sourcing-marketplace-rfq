<?php

namespace App\Modules\Sourcing\Concerns;

use Illuminate\Support\Facades\Gate;

trait BootsModuleResources
{
    protected function bootModuleMigrations(): void
    {
        $path = dirname((new \ReflectionClass(static::class))->getFileName()).'/Database/Migrations';

        if (is_dir($path)) {
            $this->loadMigrationsFrom($path);
        }
    }

    /**
     * @param  array<class-string, class-string>  $policies
     */
    protected function bootModulePolicies(array $policies): void
    {
        foreach ($policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }

    /**
     * @param  list<class-string>  $resources
     */
    protected function registerBuyerFilamentResources(array $resources): void
    {
        // Buyer panel auto-discovers App\Modules\Sourcing\*\Filament\Buyer\Resources.
    }
}
