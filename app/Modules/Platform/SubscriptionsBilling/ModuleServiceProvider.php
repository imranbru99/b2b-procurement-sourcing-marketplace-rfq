<?php

namespace App\Modules\Platform\SubscriptionsBilling;

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
                \App\Modules\Platform\SubscriptionsBilling\Filament\Platform\Resources\PlanResource::class,
                \App\Modules\Platform\SubscriptionsBilling\Filament\Platform\Resources\PlanPriceResource::class,
                \App\Modules\Platform\SubscriptionsBilling\Filament\Platform\Resources\SubscriptionResource::class,
                \App\Modules\Platform\SubscriptionsBilling\Filament\Platform\Resources\SubscriptionInvoiceResource::class,
                \App\Modules\Platform\SubscriptionsBilling\Filament\Platform\Resources\UsageLimitResource::class,
                \App\Modules\Platform\SubscriptionsBilling\Filament\Platform\Resources\CouponPlatformResource::class
            ],
        ]);
        
    }

    protected function registerPolicies(): void
    {
        Gate::policy(\App\Modules\Platform\SubscriptionsBilling\Models\Plan::class, \App\Modules\Platform\SubscriptionsBilling\Policies\PlanPolicy::class);
        Gate::policy(\App\Modules\Platform\SubscriptionsBilling\Models\PlanPrice::class, \App\Modules\Platform\SubscriptionsBilling\Policies\PlanPricePolicy::class);
        Gate::policy(\App\Modules\Platform\SubscriptionsBilling\Models\Subscription::class, \App\Modules\Platform\SubscriptionsBilling\Policies\SubscriptionPolicy::class);
        Gate::policy(\App\Modules\Platform\SubscriptionsBilling\Models\SubscriptionInvoice::class, \App\Modules\Platform\SubscriptionsBilling\Policies\SubscriptionInvoicePolicy::class);
        Gate::policy(\App\Modules\Platform\SubscriptionsBilling\Models\UsageLimit::class, \App\Modules\Platform\SubscriptionsBilling\Policies\UsageLimitPolicy::class);
        Gate::policy(\App\Modules\Platform\SubscriptionsBilling\Models\CouponPlatform::class, \App\Modules\Platform\SubscriptionsBilling\Policies\CouponPlatformPolicy::class);
    }
}
