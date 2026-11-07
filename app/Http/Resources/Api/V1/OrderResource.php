<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Modules\Orders\PurchaseOrders\Models\PurchaseOrder */
class OrderResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'organization_id' => $this->organization_id,
            'number' => $this->number,
            'status' => $this->status,
            'total' => $this->total,
            'issued_at' => $this->issued_at,
            'created_at' => $this->created_at,
        ];
    }
}
