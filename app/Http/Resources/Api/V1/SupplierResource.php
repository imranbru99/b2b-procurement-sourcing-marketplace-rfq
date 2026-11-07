<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Modules\Suppliers\Directory\Models\SupplierProfile */
class SupplierResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'organization_id' => $this->organization_id,
            'company_name' => $this->company_name,
            'slug' => $this->slug,
            'country' => $this->country,
            'city' => $this->city,
            'created_at' => $this->created_at,
        ];
    }
}
