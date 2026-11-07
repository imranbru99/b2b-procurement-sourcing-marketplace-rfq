<?php

namespace App\Modules\Sourcing\AwardsContracts\Services;

use App\Modules\Sourcing\AwardsContracts\Models\Award;
use App\Modules\Sourcing\Bidding\Models\Bid;
use App\Modules\Sourcing\BidScoring\Models\BidScore;
use App\Modules\Sourcing\BidScoring\Models\ScoringCriterion;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class RfqAwardWorkflow
{
    public function awardTopScoredBid(Rfq $rfq, Bid $bid, float $percentage = 100): Award
    {
        return DB::transaction(function () use ($rfq, $bid, $percentage) {
            if ((int) $bid->rfq_id !== (int) $rfq->id) {
                throw new InvalidArgumentException('Bid does not belong to this RFQ.');
            }

            if (! in_array($bid->status, ['submitted', 'awarded'], true)) {
                throw new InvalidArgumentException('Only submitted bids can be awarded.');
            }

            Bid::query()
                ->withoutGlobalScope('organization')
                ->where('rfq_id', $rfq->id)
                ->where('id', '!=', $bid->id)
                ->where('status', 'submitted')
                ->update(['status' => 'rejected']);

            $bid->update(['status' => 'awarded']);

            $award = Award::query()->create([
                'organization_id' => $rfq->organization_id,
                'rfq_id' => $rfq->id,
                'bid_id' => $bid->id,
                'supplier_organization_id' => $bid->supplier_organization_id,
                'awarded_amount' => (float) $bid->total * ($percentage / 100),
                'award_percentage' => $percentage,
                'currency' => $bid->currency,
                'status' => 'awarded',
                'awarded_at' => now(),
            ]);

            $rfq->update(['status' => 'awarded']);

            return $award;
        });
    }

    public function totalWeightedScore(Bid $bid): float
    {
        return (float) BidScore::query()
            ->withoutGlobalScope('organization')
            ->where('bid_id', $bid->id)
            ->sum('weighted_score');
    }

    public function ensureCriterion(Rfq $rfq, string $name, float $weight = 1, float $maxScore = 100): ScoringCriterion
    {
        return ScoringCriterion::query()->create([
            'organization_id' => $rfq->organization_id,
            'rfq_id' => $rfq->id,
            'name' => $name,
            'weight' => $weight,
            'max_score' => $maxScore,
        ]);
    }
}
