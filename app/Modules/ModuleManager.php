<?php

namespace App\Modules;

use App\Models\Module as ModuleModel;
use App\Models\Organization;
use App\Models\OrganizationModule;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ModuleManager
{
    protected const CACHE_PREFIX = 'org_modules:';

    public function __construct(
        protected ModuleRegistry $registry,
        protected CacheRepository $cache,
    ) {}

    public function enabled(?string $key = null, ?int $organizationId = null): bool
    {
        $organizationId ??= organization_id();

        if ($organizationId === null) {
            if ($key === null) {
                return false;
            }

            $module = $this->registry->get($key);

            return $module?->defaultEnabled() ?? false;
        }

        $enabledKeys = $this->enabledKeysForOrganization($organizationId);

        if ($key === null) {
            return $enabledKeys->isNotEmpty();
        }

        return $enabledKeys->contains($key);
    }

    /**
     * @return Collection<int, string>
     */
    public function enabledKeysForOrganization(int $organizationId): Collection
    {
        return $this->cache->remember(
            self::CACHE_PREFIX.$organizationId,
            now()->addHour(),
            function () use ($organizationId) {
                $query = OrganizationModule::query()->where('organization_id', $organizationId);

                if (! $query->exists()) {
                    return $this->registry->all()
                        ->filter(fn (Contracts\ModuleInterface $module) => $module->defaultEnabled())
                        ->keys();
                }

                return OrganizationModule::query()
                    ->where('organization_id', $organizationId)
                    ->where('enabled', true)
                    ->pluck('module_key');
            }
        );
    }

    public function enable(Organization $organization, string $key): void
    {
        $module = $this->registry->get($key);

        if ($module === null) {
            throw new RuntimeException("Unknown module [{$key}].");
        }

        foreach ($module->dependencies() as $dependency) {
            if (! $this->enabled($dependency, $organization->id)) {
                throw new RuntimeException(
                    "Cannot enable [{$key}]: dependency [{$dependency}] is not enabled."
                );
            }
        }

        DB::transaction(function () use ($organization, $module, $key) {
            ModuleModel::query()->updateOrCreate(
                ['key' => $key],
                [
                    'name' => $module->name(),
                    'description' => $module->description(),
                    'group' => $module->group(),
                    'icon' => $module->icon(),
                    'is_core' => $module->isCore(),
                    'default_enabled' => $module->defaultEnabled(),
                    'dependencies' => $module->dependencies(),
                    'permissions' => $module->permissions(),
                ]
            );

            OrganizationModule::query()->updateOrCreate(
                [
                    'organization_id' => $organization->id,
                    'module_key' => $key,
                ],
                [
                    'enabled' => true,
                    'enabled_at' => now(),
                    'disabled_at' => null,
                ]
            );
        });

        $this->forgetOrganizationCache($organization->id);
    }

    public function disable(Organization $organization, string $key): void
    {
        $module = $this->registry->get($key);

        if ($module === null) {
            throw new RuntimeException("Unknown module [{$key}].");
        }

        if ($module->isCore()) {
            throw new RuntimeException("Core module [{$key}] cannot be disabled.");
        }

        $dependents = $this->registry->all()->filter(function (Contracts\ModuleInterface $candidate) use ($key, $organization) {
            if (! in_array($key, $candidate->dependencies(), true)) {
                return false;
            }

            return $this->enabled($candidate->key(), $organization->id);
        });

        if ($dependents->isNotEmpty()) {
            $names = $dependents->map(fn (Contracts\ModuleInterface $m) => $m->key())->implode(', ');

            throw new RuntimeException(
                "Cannot disable [{$key}]: enabled modules depend on it: {$names}."
            );
        }

        OrganizationModule::query()
            ->where('organization_id', $organization->id)
            ->where('module_key', $key)
            ->update([
                'enabled' => false,
                'disabled_at' => now(),
            ]);

        $this->forgetOrganizationCache($organization->id);
    }

    public function syncRegistryToDatabase(): void
    {
        foreach ($this->registry->all() as $module) {
            ModuleModel::query()->updateOrCreate(
                ['key' => $module->key()],
                [
                    'name' => $module->name(),
                    'description' => $module->description(),
                    'group' => $module->group(),
                    'icon' => $module->icon(),
                    'is_core' => $module->isCore(),
                    'default_enabled' => $module->defaultEnabled(),
                    'dependencies' => $module->dependencies(),
                    'permissions' => $module->permissions(),
                ]
            );
        }
    }

    public function forgetOrganizationCache(int $organizationId): void
    {
        $this->cache->forget(self::CACHE_PREFIX.$organizationId);
    }
}
