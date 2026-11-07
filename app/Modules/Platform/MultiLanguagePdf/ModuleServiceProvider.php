<?php

namespace App\Modules\Platform\MultiLanguagePdf;

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
                \App\Modules\Platform\MultiLanguagePdf\Filament\Platform\Resources\DocumentTemplateResource::class
            ],
        ]);
        $this->app->singleton(\App\Modules\Platform\MultiLanguagePdf\Services\DocumentPdfService::class);
    }

    protected function registerPolicies(): void
    {
        Gate::policy(\App\Modules\Platform\MultiLanguagePdf\Models\DocumentTemplate::class, \App\Modules\Platform\MultiLanguagePdf\Policies\DocumentTemplatePolicy::class);
    }
}
