<?php

namespace App\Modules\Sourcing\BidScoring\Services;

use App\Modules\Sourcing\Bidding\Models\Bid;

class TcoCalculatorService
{
    /**
     * Total cost of ownership: bid total plus logistics / holding cost heuristic.
     */
    public function calculate(Bid $bid, float $logisticsCost = 0, float $holdingCostPerDay = 0, ?int $leadTimeDays = null): float
    {
        $leadTimeDays ??= (int) ($bid->lead_time_days ?? 0);
        $base = (float) $bid->total;

        return round($base + $logisticsCost + ($holdingCostPerDay * $leadTimeDays), 2);
    }
}
