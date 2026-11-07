<?php

namespace App\Modules\Platform\DataImportExport;

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
                \App\Modules\Platform\DataImportExport\Filament\Platform\Resources\ImportJobResource::class,
                \App\Modules\Platform\DataImportExport\Filament\Platform\Resources\ExportJobResource::class,
                \App\Modules\Platform\DataImportExport\Filament\Platform\Resources\BackupLogResource::class
            ],
        ]);
        
    }

    protected function registerPolicies(): void
    {
        Gate::policy(\App\Modules\Platform\DataImportExport\Models\ImportJob::class, \App\Modules\Platform\DataImportExport\Policies\ImportJobPolicy::class);
        Gate::policy(\App\Modules\Platform\DataImportExport\Models\ExportJob::class, \App\Modules\Platform\DataImportExport\Policies\ExportJobPolicy::class);
        Gate::policy(\App\Modules\Platform\DataImportExport\Models\BackupLog::class, \App\Modules\Platform\DataImportExport\Policies\BackupLogPolicy::class);
    }
}
