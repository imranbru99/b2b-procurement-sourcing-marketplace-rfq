<?php

namespace App\Providers;

use App\Http\Middleware\EnsureModuleEnabled;
use App\Modules\ModuleManager;
use App\Modules\ModuleRegistry;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(ModuleRegistry::class);
        $this->app->singleton(ModuleManager::class);

        $this->app->alias(ModuleManager::class, 'module.manager');

        foreach ($this->discoverModuleProviders() as $providerClass) {
            $this->app->register($providerClass);
        }
    }

    public function boot(): void
    {
        Blade::if('module', function (string $key, ?int $organizationId = null): bool {
            return module_enabled($key, $organizationId);
        });

        $this->app['router']->aliasMiddleware('module', EnsureModuleEnabled::class);
    }

    /**
     * @return list<class-string<ServiceProvider>>
     */
    protected function discoverModuleProviders(): array
    {
        $providers = [];

        foreach ($this->app->make(ModuleRegistry::class)->all() as $module) {
            $class = $module->serviceProviderClass();

            if ($class !== null && class_exists($class)) {
                $providers[] = $class;
            }
        }

        return $providers;
    }
}
