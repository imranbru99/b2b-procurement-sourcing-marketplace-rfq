<?php

namespace App\Modules\Intelligence\AnalyticsReporting\Services;

use App\Modules\Orders\Invoicing\Models\Invoice;
use App\Modules\Orders\PurchaseOrders\Models\PurchaseOrder;
use Illuminate\Support\Facades\DB;

class SpendAnalyticsService
{
    /**
     * @return array<string, float>
     */
    public function spendBySupplier(?int $organizationId = null): array
    {
        $organizationId ??= organization_id();

        return PurchaseOrder::query()
            ->when($organizationId, fn ($query) => $query->where('organization_id', $organizationId))
            ->whereNotNull('supplier_organization_id')
            ->select('supplier_organization_id', DB::raw('SUM(total) as spend'))
            ->groupBy('supplier_organization_id')
            ->orderByDesc('spend')
            ->pluck('spend', 'supplier_organization_id')
            ->map(fn ($value) => (float) $value)
            ->all();
    }

    /**
     * @return array<string, float>
     */
    public function spendByCategory(?int $organizationId = null): array
    {
        $organizationId ??= organization_id();

        $fromBudgets = DB::table('budgets')
            ->when($organizationId, fn ($query) => $query->where('organization_id', $organizationId))
            ->select('name as category', DB::raw('SUM(spent) as spend'))
            ->groupBy('name')
            ->pluck('spend', 'category');

        if ($fromBudgets->isNotEmpty()) {
            return $fromBudgets->map(fn ($value) => (float) $value)->all();
        }

        return Invoice::query()
            ->when($organizationId, fn ($query) => $query->where('organization_id', $organizationId))
            ->select('status as category', DB::raw('SUM(total) as spend'))
            ->groupBy('status')
            ->pluck('spend', 'category')
            ->map(fn ($value) => (float) $value)
            ->all();
    }
}
