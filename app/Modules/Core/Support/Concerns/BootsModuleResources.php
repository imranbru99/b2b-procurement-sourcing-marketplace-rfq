<?php

namespace App\Modules\Core\Support\Concerns;

use Filament\Facades\Filament;
use Illuminate\Support\Facades\Gate;

trait BootsModuleResources
{
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
     * @param  array<string, list<class-string>>  $resourcesByPanel
     */
    protected function registerFilamentResources(array $resourcesByPanel): void
    {
        if (! class_exists(Filament::class)) {
            return;
        }

        Filament::serving(function () use ($resourcesByPanel): void {
            foreach ($resourcesByPanel as $panelId => $resources) {
                $panel = Filament::getPanel($panelId);

                foreach ($resources as $resource) {
                    if (! $panel->hasResource($resource)) {
                        $panel->registerResources([$resource]);
                    }
                }
            }
        });
    }

    /**
     * @param  array<string, list<class-string>>  $pagesByPanel
     */
    protected function registerFilamentPages(array $pagesByPanel): void
    {
        if (! class_exists(Filament::class)) {
            return;
        }

        Filament::serving(function () use ($pagesByPanel): void {
            foreach ($pagesByPanel as $panelId => $pages) {
                $panel = Filament::getPanel($panelId);

                foreach ($pages as $page) {
                    if (! $panel->hasPage($page)) {
                        $panel->registerPages([$page]);
                    }
                }
            }
        });
    }

    /**
     * @param  array<string, list<class-string>>  $widgetsByPanel
     */
    protected function registerFilamentWidgets(array $widgetsByPanel): void
    {
        if (! class_exists(Filament::class)) {
            return;
        }

        Filament::serving(function () use ($widgetsByPanel): void {
            foreach ($widgetsByPanel as $panelId => $widgets) {
                $panel = Filament::getPanel($panelId);

                foreach ($widgets as $widget) {
                    if (! in_array($widget, $panel->getWidgets(), true)) {
                        $panel->registerWidgets([$widget]);
                    }
                }
            }
        });
    }
}
