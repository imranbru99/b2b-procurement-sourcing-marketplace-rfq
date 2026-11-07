<?php

use App\Services\Packages\AdminPanelService;
use ImranDevBD\LaravelAdminPanel\Facades\AdminPanel;

it('exposes admin panel version through the integration service', function () {
    $service = app(AdminPanelService::class);

    $service->ensureInstalled();

    expect($service->version())->toBe(AdminPanel::version())
        ->and($service->version())->not->toBeEmpty();
});
