<?php

use App\Models\Organization;
use App\Models\OrganizationModule;
use App\Modules\ModuleManager;
use Database\Seeders\ModuleSeeder;
use Illuminate\Support\Facades\Cache;

beforeEach(function () {
    $this->seed(ModuleSeeder::class);
});

it('seeds modules from the registry', function () {
    expect(\App\Models\Module::query()->count())->toBeGreaterThanOrEqual(9);
});

it('enables a module when dependencies are satisfied', function () {
    $organization = Organization::query()->create([
        'name' => 'Acme Procurement',
        'type' => 'buyer',
    ]);

    $manager = app(ModuleManager::class);

    $manager->enable($organization, 'core.organizations');
    $manager->enable($organization, 'marketplace.rfq');

    expect($manager->enabled('marketplace.rfq', $organization->id))->toBeTrue();
});

it('blocks enabling when a dependency is disabled', function () {
    $organization = Organization::query()->create([
        'name' => 'Blocked Buyer',
        'type' => 'buyer',
    ]);

    OrganizationModule::query()->create([
        'organization_id' => $organization->id,
        'module_key' => 'core.organizations',
        'enabled' => false,
        'disabled_at' => now(),
    ]);

    Cache::flush();

    app(ModuleManager::class)->enable($organization, 'marketplace.rfq');
})->throws(RuntimeException::class, 'dependency');

it('blocks disabling core modules', function () {
    $organization = Organization::query()->create([
        'name' => 'Core Org',
        'type' => 'buyer',
    ]);

    $manager = app(ModuleManager::class);
    $manager->enable($organization, 'core.organizations');
    $manager->disable($organization, 'core.organizations');
})->throws(RuntimeException::class, 'Core module');

it('blocks disabling a module when dependents are enabled', function () {
    $organization = Organization::query()->create([
        'name' => 'Dependent Org',
        'type' => 'supplier',
    ]);

    $manager = app(ModuleManager::class);
    $manager->enable($organization, 'core.organizations');
    $manager->enable($organization, 'marketplace.rfq');
    $manager->enable($organization, 'marketplace.bids');

    $manager->disable($organization, 'marketplace.rfq');
})->throws(RuntimeException::class, 'depend on it');

it('disables a non-core module when no dependents are active', function () {
    $organization = Organization::query()->create([
        'name' => 'Disable Org',
        'type' => 'buyer',
    ]);

    $manager = app(ModuleManager::class);
    $manager->enable($organization, 'core.organizations');
    $manager->enable($organization, 'marketplace.rfq');

    $manager->disable($organization, 'marketplace.rfq');

    expect($manager->enabled('marketplace.rfq', $organization->id))->toBeFalse();
});

it('exposes module_enabled helper', function () {
    $organization = Organization::query()->create([
        'name' => 'Helper Org',
        'type' => 'buyer',
    ]);

    app(ModuleManager::class)->enable($organization, 'core.organizations');

    expect(module_enabled('core.organizations', $organization->id))->toBeTrue();
});
