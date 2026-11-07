<?php

namespace App\Modules\Sourcing\BidScoring;

use App\Modules\Sourcing\BidScoring\Models\ScoringCriterion;
use App\Modules\Sourcing\BidScoring\Policies\ScoringCriterionPolicy;
use App\Modules\Sourcing\Concerns\BootsModuleResources;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    use BootsModuleResources;

    public function register(): void
    {
        $this->app->singleton(Services\TcoCalculatorService::class);
    }

    public function boot(): void
    {
        $this->bootModuleMigrations();
        $this->bootModulePolicies([
            ScoringCriterion::class => ScoringCriterionPolicy::class,
        ]);
    }
}
