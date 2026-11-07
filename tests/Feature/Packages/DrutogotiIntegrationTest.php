<?php

use App\Services\Packages\DrutogotiService;

it('exposes drutogoti configuration through the application service', function () {
    $service = app(DrutogotiService::class);

    expect($service->isEnabled())->toBeFalse()
        ->and($service->enabledWatchers())->toContain('queries')
        ->and($service->documentation())->toContain('DRUTOGOTI_ENABLED');
});

it('reflects drutogoti enablement from configuration', function () {
    config(['drutogoti.enabled' => true]);

    expect(app(DrutogotiService::class)->isEnabled())->toBeTrue();
});
