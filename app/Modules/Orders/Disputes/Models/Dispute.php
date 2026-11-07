<?php

namespace App\Modules\Orders\Disputes\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Modules\Orders\Disputes\Database\Factories\DisputeFactory;
use App\Modules\Orders\Payments\Models\Payment;
use App\Modules\Orders\PurchaseOrders\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dispute extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'disputes';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'opened_at' => 'datetime',
        ];
    }

    protected static function newFactory(): DisputeFactory
    {
        return DisputeFactory::new();
    }

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function evidence(): HasMany
    {
        return $this->hasMany(DisputeEvidence::class, 'dispute_id');
    }

    public function resolutions(): HasMany
    {
        return $this->hasMany(DisputeResolution::class, 'dispute_id');
    }
}
