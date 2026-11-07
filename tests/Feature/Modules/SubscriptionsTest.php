<?php

use App\Models\Organization;
use App\Modules\Platform\SubscriptionsBilling\Models\Plan;
use App\Modules\Platform\SubscriptionsBilling\Models\PlanPrice;
use App\Modules\Platform\SubscriptionsBilling\Models\Subscription;

it('links subscriptions to plans with module entitlements', function () {
    $organization = Organization::query()->create([
        'name' => 'SaaS Buyer',
        'type' => 'buyer',
    ]);

    $plan = Plan::query()->create([
        'name' => 'Growth',
        'modules' => ['platform.helpdesk', 'platform.cms-blog'],
        'is_active' => true,
    ]);

    PlanPrice::query()->create([
        'plan_id' => $plan->id,
        'currency' => 'USD',
        'amount' => 99,
        'interval' => 'month',
    ]);

    $subscription = Subscription::query()->withoutGlobalScope('organization')->create([
        'organization_id' => $organization->id,
        'plan_id' => $plan->id,
        'status' => 'active',
        'starts_at' => now(),
    ]);

    expect($subscription->fresh()->plan->modules)->toContain('platform.helpdesk')
        ->and($plan->slug)->not->toBeEmpty();
});
