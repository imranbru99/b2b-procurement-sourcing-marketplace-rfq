<?php

namespace Database\Seeders\Concerns;

use App\Models\Organization;
use App\Models\OrganizationModule;
use App\Modules\ModuleManager;
use App\Modules\ModuleRegistry;

trait SyncsOrganizationModules
{
    /**
     * @param  list<string>  $enabledKeys
     */
    protected function syncOrganizationModules(Organization $organization, array $enabledKeys): void
    {
        $registry = app(ModuleRegistry::class);
        $manager = app(ModuleManager::class);
        $enabled = array_fill_keys($enabledKeys, true);

        foreach ($registry->keys() as $key) {
            $isEnabled = isset($enabled[$key]);

            OrganizationModule::query()->updateOrCreate(
                [
                    'organization_id' => $organization->id,
                    'module_key' => $key,
                ],
                [
                    'enabled' => $isEnabled,
                    'enabled_at' => $isEnabled ? now() : null,
                    'disabled_at' => $isEnabled ? null : now(),
                ]
            );
        }

        $manager->forgetOrganizationCache($organization->id);
    }
}
