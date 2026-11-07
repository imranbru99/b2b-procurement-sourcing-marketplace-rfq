<?php

namespace App\Modules\Platform\ApiIntegrations;

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
                \App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\WebhookEndpointResource::class,
                \App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\WebhookDeliveryResource::class,
                \App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\ApiLogResource::class,
                \App\Modules\Platform\ApiIntegrations\Filament\Platform\Resources\ErpConnectorResource::class
            ],
        ]);
        
    }

    protected function registerPolicies(): void
    {
        Gate::policy(\App\Modules\Platform\ApiIntegrations\Models\WebhookEndpoint::class, \App\Modules\Platform\ApiIntegrations\Policies\WebhookEndpointPolicy::class);
        Gate::policy(\App\Modules\Platform\ApiIntegrations\Models\WebhookDelivery::class, \App\Modules\Platform\ApiIntegrations\Policies\WebhookDeliveryPolicy::class);
        Gate::policy(\App\Modules\Platform\ApiIntegrations\Models\ApiLog::class, \App\Modules\Platform\ApiIntegrations\Policies\ApiLogPolicy::class);
        Gate::policy(\App\Modules\Platform\ApiIntegrations\Models\ErpConnector::class, \App\Modules\Platform\ApiIntegrations\Policies\ErpConnectorPolicy::class);
    }
}
