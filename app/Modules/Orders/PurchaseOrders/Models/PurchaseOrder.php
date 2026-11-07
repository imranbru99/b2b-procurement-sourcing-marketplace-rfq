<?php

namespace App\Modules\Orders\PurchaseOrders\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Models\Organization;
use App\Modules\Orders\GoodsReceipt\Models\Grn;
use App\Modules\Orders\Invoicing\Models\Invoice;
use App\Modules\Orders\PurchaseOrders\Database\Factories\PurchaseOrderFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'purchase_orders';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'subtotal' => 'decimal:2',
            'tax_total' => 'decimal:2',
            'total' => 'decimal:2',
            'issued_at' => 'datetime',
            'expected_delivery_at' => 'datetime',
        ];
    }

    protected static function newFactory(): PurchaseOrderFactory
    {
        return PurchaseOrderFactory::new();
    }

    public function supplierOrganization(): BelongsTo
    {
        return $this->belongsTo(Organization::class, 'supplier_organization_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(PoItem::class, 'purchase_order_id');
    }

    public function revisions(): HasMany
    {
        return $this->hasMany(PoRevision::class, 'purchase_order_id');
    }

    public function acknowledgments(): HasMany
    {
        return $this->hasMany(PoAcknowledgment::class, 'purchase_order_id');
    }

    public function grns(): HasMany
    {
        return $this->hasMany(Grn::class, 'purchase_order_id');
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class, 'purchase_order_id');
    }
}
