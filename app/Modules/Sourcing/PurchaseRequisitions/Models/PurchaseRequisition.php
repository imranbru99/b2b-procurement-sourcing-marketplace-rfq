<?php

namespace App\Modules\Sourcing\PurchaseRequisitions\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\User;
use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseRequisition extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'purchase_requisitions';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
        ];
    }

    public function requester(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    public function lineItems(): HasMany
    {
        return $this->hasMany(PurchaseRequisitionLineItem::class);
    }

    public function approvals(): HasMany
    {
        return $this->hasMany(RequisitionApproval::class);
    }

    public function rfqs(): HasMany
    {
        return $this->hasMany(Rfq::class);
    }

    protected static function newFactory(): \App\Modules\Sourcing\PurchaseRequisitions\Database\Factories\PurchaseRequisitionFactory
    {
        return \App\Modules\Sourcing\PurchaseRequisitions\Database\Factories\PurchaseRequisitionFactory::new();
    }
}
