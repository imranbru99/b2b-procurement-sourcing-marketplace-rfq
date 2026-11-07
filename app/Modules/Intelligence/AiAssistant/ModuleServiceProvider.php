<?php

namespace App\Modules\Intelligence\AiAssistant;

use App\Modules\Intelligence\Support\Concerns\BootsModuleResources;
use App\Services\Packages\AiHubService;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    use BootsModuleResources;

    public function register(): void
    {
        $this->app->singleton(AiHubService::class);
    }

    public function boot(): void
    {
        $this->bootModuleMigrations();

        $this->bootModulePolicies([
            \App\Modules\Intelligence\AiAssistant\Models\AiUsageLog::class => \App\Modules\Intelligence\AiAssistant\Policies\AiUsageLogPolicy::class,
        ]);

        $this->registerBuyerFilamentResources([
            \App\Modules\Intelligence\AiAssistant\Filament\Resources\AiUsageLogResource::class,
        ]);

        $this->registerBuyerFilamentPages([
            \App\Modules\Intelligence\AiAssistant\Filament\Pages\AiAssistantChatPage::class,
        ]);
    }
}
