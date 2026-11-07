<?php

namespace App\Modules\Sourcing\PurchaseRequisitions\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RequisitionApproval extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'requisition_approvals';

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'acted_at' => 'datetime',
        ];
    }

    public function purchaseRequisition(): BelongsTo
    {
        return $this->belongsTo(PurchaseRequisition::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    protected static function newFactory(): \App\Modules\Sourcing\PurchaseRequisitions\Database\Factories\RequisitionApprovalFactory
    {
        return \App\Modules\Sourcing\PurchaseRequisitions\Database\Factories\RequisitionApprovalFactory::new();
    }
}
