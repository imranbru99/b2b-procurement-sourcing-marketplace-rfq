<?php

namespace App\Modules\Orders\PurchaseOrders\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Modules\Orders\PurchaseOrders\Database\Factories\PoItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PoItem extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'po_items';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'quantity' => 'decimal:2',
            'unit_price' => 'decimal:2',
            'line_total' => 'decimal:2',
        ];
    }

    protected static function newFactory(): PoItemFactory
    {
        return PoItemFactory::new();
    }

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }
}
