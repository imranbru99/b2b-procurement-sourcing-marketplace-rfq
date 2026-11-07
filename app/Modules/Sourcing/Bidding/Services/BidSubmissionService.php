<?php

namespace App\Modules\Sourcing\Bidding\Services;

use App\Modules\Sourcing\Bidding\Models\Bid;
use App\Modules\Sourcing\Bidding\Models\BidRevision;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class BidSubmissionService
{
    public function submit(Bid $bid): Bid
    {
        return DB::transaction(function () use ($bid) {
            $rfq = Rfq::query()
                ->withoutGlobalScope('organization')
                ->find($bid->rfq_id);

            if (! $rfq || $rfq->status !== 'open') {
                throw new InvalidArgumentException('RFQ is not open for bidding.');
            }

            if ($rfq->deadline !== null && $rfq->deadline->isPast()) {
                throw new InvalidArgumentException('RFQ deadline has passed.');
            }

            $bid->loadMissing('items');

            $revisionNumber = (int) BidRevision::query()
                ->withoutGlobalScope('organization')
                ->where('bid_id', $bid->id)
                ->max('revision_number');

            BidRevision::query()->create([
                'organization_id' => $bid->organization_id,
                'bid_id' => $bid->id,
                'revision_number' => $revisionNumber + 1,
                'total' => $bid->total,
                'snapshot' => [
                    'status' => $bid->status,
                    'total' => (string) $bid->total,
                    'currency' => $bid->currency,
                    'lead_time_days' => $bid->lead_time_days,
                    'valid_until' => optional($bid->valid_until)?->toIso8601String(),
                    'is_sealed' => $bid->is_sealed,
                    'items' => $bid->items->map(fn ($item) => $item->only([
                        'id',
                        'rfq_item_id',
                        'quantity',
                        'unit_price',
                        'line_total',
                    ]))->all(),
                ],
                'revised_at' => now(),
            ]);

            $bid->update([
                'status' => 'submitted',
                'submitted_at' => now(),
            ]);

            return $bid->fresh(['items', 'revisions']);
        });
    }
}
