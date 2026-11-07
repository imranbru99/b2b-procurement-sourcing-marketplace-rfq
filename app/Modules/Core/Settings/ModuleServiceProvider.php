<?php

namespace App\Modules\Core\Settings;

use App\Modules\Core\Settings\Models\Setting;
use App\Modules\Core\Settings\Policies\SettingPolicy;
use App\Modules\Core\Settings\Services\SettingService;
use App\Modules\Core\Support\Concerns\BootsModuleResources;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    use BootsModuleResources;

    public function register(): void
    {
        $this->app->singleton(SettingService::class);
    }

    public function boot(): void
    {
        $this->bootModulePolicies([
            Setting::class => SettingPolicy::class,
        ]);
    }
}
