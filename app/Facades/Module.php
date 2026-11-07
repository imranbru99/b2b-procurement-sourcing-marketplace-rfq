<?php

namespace App\Facades;

use App\Modules\ModuleManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static bool enabled(?string $key = null, ?int $organizationId = null)
 * @method static void enable(\App\Models\Organization $organization, string $key)
 * @method static void disable(\App\Models\Organization $organization, string $key)
 * @method static \Illuminate\Support\Collection enabledKeysForOrganization(int $organizationId)
 *
 * @see ModuleManager
 */
class Module extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return ModuleManager::class;
    }
}
