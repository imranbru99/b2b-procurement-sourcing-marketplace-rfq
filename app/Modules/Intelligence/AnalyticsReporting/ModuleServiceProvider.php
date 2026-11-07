<?php

namespace App\Modules\Intelligence\AnalyticsReporting;

use App\Modules\Intelligence\AnalyticsReporting\Services\CycleTimeAnalyzer;
use App\Modules\Intelligence\AnalyticsReporting\Services\SavingsTracker;
use App\Modules\Intelligence\AnalyticsReporting\Services\SpendAnalyticsService;
use App\Modules\Intelligence\Support\Concerns\BootsModuleResources;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    use BootsModuleResources;

    public function register(): void
    {
        $this->app->singleton(SpendAnalyticsService::class);
        $this->app->singleton(SavingsTracker::class);
        $this->app->singleton(CycleTimeAnalyzer::class);
    }

    public function boot(): void
    {
        $this->bootModuleMigrations();

        $this->bootModulePolicies([
            \App\Modules\Intelligence\AnalyticsReporting\Models\SavedReport::class => \App\Modules\Intelligence\AnalyticsReporting\Policies\SavedReportPolicy::class,
            \App\Modules\Intelligence\AnalyticsReporting\Models\ScheduledReportEmail::class => \App\Modules\Intelligence\AnalyticsReporting\Policies\ScheduledReportEmailPolicy::class,
        ]);

        $this->registerBuyerFilamentResources([
            \App\Modules\Intelligence\AnalyticsReporting\Filament\Resources\SavedReportResource::class,
        ]);

        $this->registerBuyerFilamentWidgets([
            \App\Modules\Intelligence\AnalyticsReporting\Filament\Widgets\SpendByCategoryWidget::class,
            \App\Modules\Intelligence\AnalyticsReporting\Filament\Widgets\SpendBySupplierWidget::class,
        ]);
    }
}
