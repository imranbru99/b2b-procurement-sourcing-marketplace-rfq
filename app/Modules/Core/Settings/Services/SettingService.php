<?php

namespace App\Modules\Core\Settings\Services;

use App\Modules\Core\Settings\Models\Setting;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Support\Collection;

class SettingService
{
    protected const CACHE_PREFIX = 'settings:';

    public function __construct(
        protected CacheRepository $cache,
    ) {}

    public function get(string $key, mixed $default = null, ?string $group = 'general', ?int $organizationId = null): mixed
    {
        $organizationId ??= organization_id();
        $group ??= 'general';

        $settings = $this->getGroup($group, $organizationId);

        return array_key_exists($key, $settings) ? $settings[$key] : $default;
    }

    /**
     * @return array<string, mixed>
     */
    public function getGroup(string $group = 'general', ?int $organizationId = null): array
    {
        $organizationId ??= organization_id();

        return $this->cache->remember(
            $this->cacheKey($group, $organizationId),
            now()->addHour(),
            function () use ($group, $organizationId): array {
                $query = Setting::query()
                    ->withoutGlobalScopes()
                    ->where('group', $group);

                if ($organizationId === null) {
                    $query->whereNull('organization_id');
                } else {
                    $query->where(function ($builder) use ($organizationId): void {
                        $builder->where('organization_id', $organizationId)
                            ->orWhereNull('organization_id');
                    });
                }

                /** @var Collection<int, Setting> $rows */
                $rows = $query->orderByRaw('organization_id is null')->get();

                $resolved = [];

                foreach ($rows as $setting) {
                    // Organization-scoped values override platform defaults.
                    if ($setting->organization_id === null && array_key_exists($setting->key, $resolved)) {
                        continue;
                    }

                    $resolved[$setting->key] = $setting->value;
                }

                return $resolved;
            }
        );
    }

    public function set(string $key, mixed $value, ?string $group = 'general', ?int $organizationId = null, bool $isLocked = false): Setting
    {
        $organizationId ??= organization_id();
        $group ??= 'general';

        $existing = Setting::query()
            ->withoutGlobalScopes()
            ->where('group', $group)
            ->where('key', $key)
            ->where(function ($builder) use ($organizationId): void {
                if ($organizationId === null) {
                    $builder->whereNull('organization_id');
                } else {
                    $builder->where('organization_id', $organizationId);
                }
            })
            ->first();

        if ($existing?->is_locked) {
            throw new \RuntimeException("Setting [{$group}.{$key}] is locked and cannot be changed.");
        }

        $setting = Setting::query()->withoutGlobalScopes()->updateOrCreate(
            [
                'organization_id' => $organizationId,
                'group' => $group,
                'key' => $key,
            ],
            [
                'value' => $value,
                'is_locked' => $isLocked,
            ]
        );

        $this->forget($group, $organizationId);

        if ($organizationId !== null) {
            $this->forget($group, null);
        }

        return $setting;
    }

    public function forget(string $group = 'general', ?int $organizationId = null): void
    {
        $this->cache->forget($this->cacheKey($group, $organizationId));
    }

    protected function cacheKey(string $group, ?int $organizationId): string
    {
        return self::CACHE_PREFIX.($organizationId ?? 'platform').':'.$group;
    }
}
