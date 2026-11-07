<?php

namespace App\Modules\Platform\SecurityCenter;

use App\Modules\Platform\Support\Concerns\RegistersFilamentResources;
use App\Modules\Platform\Support\Concerns\RegistersModuleMigrations;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    use RegistersFilamentResources, RegistersModuleMigrations;

    public function register(): void {}

    public function boot(): void
    {
        $this->loadModuleMigrations();
        $this->registerPolicies();
        $this->registerFilamentForPanels([
            'platform' => [
                \App\Modules\Platform\SecurityCenter\Filament\Platform\Resources\IpAllowlistResource::class,
                \App\Modules\Platform\SecurityCenter\Filament\Platform\Resources\UserSessionTrackingResource::class,
                \App\Modules\Platform\SecurityCenter\Filament\Platform\Resources\GdprRequestResource::class,
                \App\Modules\Platform\SecurityCenter\Filament\Platform\Resources\SecuritySettingResource::class
            ],
        ]);
        
    }

    protected function registerPolicies(): void
    {
        Gate::policy(\App\Modules\Platform\SecurityCenter\Models\IpAllowlist::class, \App\Modules\Platform\SecurityCenter\Policies\IpAllowlistPolicy::class);
        Gate::policy(\App\Modules\Platform\SecurityCenter\Models\UserSessionTracking::class, \App\Modules\Platform\SecurityCenter\Policies\UserSessionTrackingPolicy::class);
        Gate::policy(\App\Modules\Platform\SecurityCenter\Models\GdprRequest::class, \App\Modules\Platform\SecurityCenter\Policies\GdprRequestPolicy::class);
        Gate::policy(\App\Modules\Platform\SecurityCenter\Models\SecuritySetting::class, \App\Modules\Platform\SecurityCenter\Policies\SecuritySettingPolicy::class);
    }
}
