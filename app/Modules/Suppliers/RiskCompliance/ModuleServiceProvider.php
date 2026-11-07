<?php

namespace App\Modules\Suppliers\RiskCompliance;

use App\Modules\Suppliers\Support\Concerns\RegistersFilamentResources;
use App\Modules\Suppliers\Support\Concerns\RegistersModuleMigrations;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    use RegistersFilamentResources, RegistersModuleMigrations;

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->loadModuleMigrations();
        $this->registerPolicies();
        $this->registerFilamentForPanels([
            'supplier' => [
                \App\Modules\Suppliers\RiskCompliance\Filament\Supplier\Resources\RiskScoreResource::class,
            ],
            'buyer' => [
                \App\Modules\Suppliers\RiskCompliance\Filament\Buyer\Resources\RiskScoreResource::class,
            ],
            'platform' => [
                \App\Modules\Suppliers\RiskCompliance\Filament\Platform\Resources\RiskScoreResource::class,
            ]
        ]);
    }

    protected function registerPolicies(): void
    {
        Gate::policy(\App\Modules\Suppliers\RiskCompliance\Models\RiskScore::class, \App\Modules\Suppliers\RiskCompliance\Policies\RiskScorePolicy::class);
        Gate::policy(\App\Modules\Suppliers\RiskCompliance\Models\ComplianceDocument::class, \App\Modules\Suppliers\RiskCompliance\Policies\ComplianceDocumentPolicy::class);
        Gate::policy(\App\Modules\Suppliers\RiskCompliance\Models\EsgQuestionnaire::class, \App\Modules\Suppliers\RiskCompliance\Policies\EsgQuestionnairePolicy::class);
        Gate::policy(\App\Modules\Suppliers\RiskCompliance\Models\ApprovedVendorList::class, \App\Modules\Suppliers\RiskCompliance\Policies\ApprovedVendorListPolicy::class);
    }
}
