<?php

namespace App\Modules\Core\Notifications;

use App\Modules\Core\Notifications\Models\MarketplaceNotification;
use App\Modules\Core\Notifications\Policies\MarketplaceNotificationPolicy;
use App\Modules\Core\Notifications\Services\NotificationService;
use App\Modules\Core\Support\Concerns\BootsModuleResources;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    use BootsModuleResources;

    public function register(): void
    {
        $this->app->singleton(NotificationService::class);
    }

    public function boot(): void
    {
        $this->bootModulePolicies([
            MarketplaceNotification::class => MarketplaceNotificationPolicy::class,
        ]);
    }
}
