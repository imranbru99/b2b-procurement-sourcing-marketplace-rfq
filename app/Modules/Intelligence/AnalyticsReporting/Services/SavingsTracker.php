<?php

namespace App\Modules\Intelligence\AnalyticsReporting\Services;

use Illuminate\Support\Facades\DB;

class SavingsTracker
{
    public function totalSavings(?int $organizationId = null): float
    {
        $organizationId ??= organization_id();

        $allocated = (float) DB::table('budgets')
            ->when($organizationId, fn ($query) => $query->where('organization_id', $organizationId))
            ->sum('allocated');

        $spent = (float) DB::table('budgets')
            ->when($organizationId, fn ($query) => $query->where('organization_id', $organizationId))
            ->sum('spent');

        return max(0, $allocated - $spent);
    }

    /**
     * @return array<string, float>
     */
    public function savingsByCostCenter(?int $organizationId = null): array
    {
        $organizationId ??= organization_id();

        return DB::table('budgets')
            ->join('cost_centers', 'budgets.cost_center_id', '=', 'cost_centers.id')
            ->when($organizationId, fn ($query) => $query->where('budgets.organization_id', $organizationId))
            ->select('cost_centers.name', DB::raw('SUM(budgets.allocated - budgets.spent) as savings'))
            ->groupBy('cost_centers.name')
            ->pluck('savings', 'name')
            ->map(fn ($value) => max(0, (float) $value))
            ->all();
    }
}
