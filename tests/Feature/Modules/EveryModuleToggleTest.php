<?php

use App\Facades\Module;
use App\Models\Organization;
use App\Modules\ModuleRegistry;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('can disable every non-core module independently without errors', function () {
    $organization = Organization::factory()->create([
        'type' => 'buyer',
        'slug' => 'toggle-org-'.uniqid(),
    ]);

    $registry = app(ModuleRegistry::class);
    $modules = $registry->all()->filter(fn ($module) => ! $module->isCore());

    expect($modules)->not->toBeEmpty();

    // Enable all non-core modules (dependencies first via repeated passes).
    $pending = $modules->keys()->all();
    $guard = 0;
    while ($pending !== [] && $guard++ < 50) {
        $still = [];
        foreach ($pending as $key) {
            try {
                Module::enable($organization, $key);
            } catch (Throwable) {
                $still[] = $key;
            }
        }
        $pending = $still;
    }

    // Disable in reverse dependency order: modules with no enabled dependents first.
    $enabled = $modules->keys()->filter(fn ($key) => Module::enabled($key, $organization->id))->values();

    $guard = 0;
    while ($enabled->isNotEmpty() && $guard++ < 50) {
        $progress = false;

        foreach ($enabled as $index => $key) {
            try {
                Module::disable($organization, $key);
                expect(Module::enabled($key, $organization->id))->toBeFalse();
                $enabled->forget($index);
                $progress = true;
            } catch (Throwable) {
                // Still has dependents enabled — try later.
            }
        }

        $enabled = $enabled->values();

        if (! $progress) {
            break;
        }
    }

    expect($enabled)->toBeEmpty();
});

it('keeps core modules enabled and rejects disabling them', function () {
    $organization = Organization::factory()->create([
        'type' => 'buyer',
        'slug' => 'core-org-'.uniqid(),
    ]);

    $core = app(ModuleRegistry::class)->all()->filter(fn ($module) => $module->isCore());

    expect($core)->not->toBeEmpty();

    $pending = $core->keys()->all();
    $guard = 0;
    while ($pending !== [] && $guard++ < 50) {
        $still = [];
        foreach ($pending as $key) {
            try {
                Module::enable($organization, $key);
            } catch (Throwable) {
                $still[] = $key;
            }
        }
        $pending = $still;
    }

    expect($pending)->toBeEmpty();

    foreach ($core as $module) {
        expect(Module::enabled($module->key(), $organization->id))->toBeTrue();

        expect(fn () => Module::disable($organization, $module->key()))
            ->toThrow(RuntimeException::class);
    }
});
