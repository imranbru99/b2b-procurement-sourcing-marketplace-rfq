<?php

namespace App\Modules\Orders\GoodsReceipt\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Modules\Orders\GoodsReceipt\Database\Factories\GrnFactory;
use App\Modules\Orders\PurchaseOrders\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grn extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'grns';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'received_at' => 'datetime',
        ];
    }

    protected static function newFactory(): GrnFactory
    {
        return GrnFactory::new();
    }

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(GrnItem::class, 'grn_id');
    }

    public function qcInspections(): HasMany
    {
        return $this->hasMany(QcInspection::class, 'grn_id');
    }

    public function goodsReturns(): HasMany
    {
        return $this->hasMany(GoodsReturn::class, 'grn_id');
    }
}
