<?php

namespace App\Modules\Operations\Concerns;

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
        if (! class_exists(\Filament\Facades\Filament::class)) {
            return;
        }

        \Filament\Facades\Filament::serving(function () use ($resources): void {
            $panel = \Filament\Facades\Filament::getPanel('buyer');

            if ($panel === null) {
                return;
            }

            foreach ($resources as $resource) {
                if (! $panel->hasResource($resource)) {
                    $panel->registerResources([$resource]);
                }
            }
        });
    }
}
