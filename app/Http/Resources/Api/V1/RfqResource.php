<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Modules\Sourcing\Rfqs\Models\Rfq */
class RfqResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'organization_id' => $this->organization_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'status' => $this->status,
            'deadline' => $this->deadline,
            'created_at' => $this->created_at,
        ];
    }
}
