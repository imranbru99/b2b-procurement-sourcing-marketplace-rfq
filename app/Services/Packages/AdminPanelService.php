<?php

namespace App\Services\Packages;

use Illuminate\Support\Facades\Artisan;
use ImranDevBD\LaravelAdminPanel\Facades\AdminPanel;

class AdminPanelService
{
    public function version(): string
    {
        return AdminPanel::version();
    }

    public function ensureInstalled(bool $force = false): void
    {
        if (! class_exists(AdminPanel::class)) {
            return;
        }

        $configPath = config_path('admin-panel.php');
        if (! file_exists($configPath) || $force) {
            Artisan::call('vendor:publish', [
                '--provider' => 'ImranDevBD\\LaravelAdminPanel\\AdminPanelServiceProvider',
                '--tag' => 'admin-panel-config',
                '--force' => $force,
            ]);
        }
    }
}
