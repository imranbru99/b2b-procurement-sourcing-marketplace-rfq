<?php

namespace App\Modules\Suppliers\Support\Concerns;

use Filament\Panel;

trait RegistersFilamentResources
{
    /**
     * @param  array<string, list<class-string>>  $resourcesByPanel
     */
    protected function registerFilamentForPanels(array $resourcesByPanel): void
    {
        if (! class_exists(Panel::class)) {
            return;
        }

        foreach ($resourcesByPanel as $panelId => $resources) {
            Panel::configureUsing(function (Panel $panel) use ($panelId, $resources): void {
                if ($panel->getId() !== $panelId) {
                    return;
                }

                $panel->resources($resources);
            });
        }
    }
}
