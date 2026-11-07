<?php

namespace App\Modules\Operations\InspectionAttendance;

use App\Modules\Operations\Concerns\BootsModuleResources;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    use BootsModuleResources;

    public function register(): void
    {
        
        $this->app->singleton(
            \App\Modules\Operations\InspectionAttendance\Services\InspectionAttendanceService::class
        );
    }

    public function boot(): void
    {
        $this->bootModuleMigrations();

        $policies = array (
  'App\\Modules\\Operations\\InspectionAttendance\\Models\\InspectorAssignment' => 'App\\Modules\\Operations\\InspectionAttendance\\Policies\\InspectorAssignmentPolicy',
  'App\\Modules\\Operations\\InspectionAttendance\\Models\\SiteAudit' => 'App\\Modules\\Operations\\InspectionAttendance\\Policies\\SiteAuditPolicy',
  'App\\Modules\\Operations\\InspectionAttendance\\Models\\AuditChecklist' => 'App\\Modules\\Operations\\InspectionAttendance\\Policies\\AuditChecklistPolicy',
);

        $this->bootModulePolicies($policies);

        $this->registerBuyerFilamentResources([
            \App\Modules\Operations\InspectionAttendance\Filament\Resources\SiteAuditResource::class,
        ]);
    }
}
