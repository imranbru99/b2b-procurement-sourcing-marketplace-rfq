<?php

namespace App\Modules\Orders\Concerns;

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
     * Register Filament resources on buyer, supplier, and platform panels.
     * Panels also discover app/Modules/Orders; this keeps explicit registration
     * for environments where discovery paths differ.
     *
     * @param  list<class-string>  $resources
     */
    protected function registerBuyerFilamentResources(array $resources): void
    {
        $this->registerFilamentResourcesOnPanels(['buyer', 'supplier', 'platform'], $resources);
    }

    /**
     * @param  list<string>  $panelIds
     * @param  list<class-string>  $resources
     */
    protected function registerFilamentResourcesOnPanels(array $panelIds, array $resources): void
    {
        if (! class_exists(\Filament\Facades\Filament::class)) {
            return;
        }

        \Filament\Facades\Filament::serving(function () use ($panelIds, $resources): void {
            foreach ($panelIds as $panelId) {
                try {
                    $panel = \Filament\Facades\Filament::getPanel($panelId);
                } catch (\Throwable) {
                    continue;
                }

                foreach ($resources as $resource) {
                    if (! $panel->hasResource($resource)) {
                        $panel->resources([$resource]);
                    }
                }
            }
        });
    }
}
