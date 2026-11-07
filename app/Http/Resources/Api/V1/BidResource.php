<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Modules\Sourcing\Bidding\Models\Bid */
class BidResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'organization_id' => $this->organization_id,
            'rfq_id' => $this->rfq_id,
            'status' => $this->status,
            'total' => $this->total,
            'submitted_at' => $this->submitted_at,
            'created_at' => $this->created_at,
        ];
    }
}
