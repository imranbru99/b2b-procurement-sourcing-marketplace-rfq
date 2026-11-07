<?php

namespace App\Modules\Sourcing\PurchaseRequisitions\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseRequisitionLineItem extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'purchase_requisition_line_items';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:4',
            'unit_price' => 'decimal:2',
            'line_total' => 'decimal:2',
        ];
    }

    public function purchaseRequisition(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequisition::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\PurchaseRequisitions\Database\Factories\PurchaseRequisitionLineItemFactory
    {
        return \App\Modules\Sourcing\PurchaseRequisitions\Database\Factories\PurchaseRequisitionLineItemFactory::new();
    }
}
