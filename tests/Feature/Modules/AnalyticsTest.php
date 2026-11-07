<?php

use App\Models\Organization;
use App\Modules\Intelligence\AnalyticsReporting\Models\SavedReport;
use App\Modules\Intelligence\AnalyticsReporting\Models\ScheduledReportEmail;
use App\Modules\Intelligence\AnalyticsReporting\Services\SavingsTracker;
use App\Modules\Intelligence\AnalyticsReporting\Services\SpendAnalyticsService;
use App\Modules\ModuleRegistry;
use App\Modules\Operations\Budgets\Models\Budget;
use App\Modules\Operations\Budgets\Models\CostCenter;
use App\Modules\Orders\PurchaseOrders\Models\PurchaseOrder;

it('registers intelligence analytics modules', function () {
    $keys = app(ModuleRegistry::class)->keys();

    expect($keys)->toContain(
        'intelligence.ai-assistant',
        'intelligence.market-data',
        'intelligence.analytics',
    );
});

it('persists saved reports and scheduled report emails', function () {
    $organization = Organization::query()->create([
        'name' => 'Buyer Org',
        'type' => 'buyer',
    ]);

    $report = SavedReport::query()->withoutGlobalScope('organization')->create([
        'organization_id' => $organization->id,
        'name' => 'Quarterly spend',
        'type' => 'spend',
        'filters' => ['range' => 'Q1'],
    ]);

    $schedule = ScheduledReportEmail::query()->withoutGlobalScope('organization')->create([
        'organization_id' => $organization->id,
        'saved_report_id' => $report->id,
        'recipient_email' => 'cfo@example.test',
        'cadence' => 'monthly',
    ]);

    expect($schedule->savedReport->is($report))->toBeTrue();
});

it('computes spend and savings analytics for an organization', function () {
    $organization = Organization::query()->create([
        'name' => 'Analytics Buyer',
        'type' => 'buyer',
    ]);

    $supplier = Organization::query()->create([
        'name' => 'Supplier Co',
        'type' => 'supplier',
    ]);

    PurchaseOrder::query()->withoutGlobalScope('organization')->create([
        'organization_id' => $organization->id,
        'supplier_organization_id' => $supplier->id,
        'number' => 'PO-100',
        'status' => 'issued',
        'total' => 1500,
        'issued_at' => now(),
    ]);

    $costCenter = CostCenter::query()->withoutGlobalScope('organization')->create([
        'organization_id' => $organization->id,
        'name' => 'MRO',
        'code' => 'MRO-01',
    ]);

    Budget::query()->withoutGlobalScope('organization')->create([
        'organization_id' => $organization->id,
        'cost_center_id' => $costCenter->id,
        'name' => 'MRO',
        'allocated' => 5000,
        'spent' => 3200,
    ]);

    $spend = app(SpendAnalyticsService::class)->spendBySupplier($organization->id);
    $savings = app(SavingsTracker::class)->totalSavings($organization->id);

    expect($spend)->not->toBeEmpty()
        ->and((float) array_sum($spend))->toEqual(1500.0)
        ->and($savings)->toEqual(1800.0);
});
