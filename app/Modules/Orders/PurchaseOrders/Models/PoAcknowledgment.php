<?php

namespace App\Modules\Orders\PurchaseOrders\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Orders\PurchaseOrders\Database\Factories\PoAcknowledgmentFactory;

class PoAcknowledgment extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'po_acknowledgments';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'acknowledged_at' => 'datetime',
);
    }

    protected static function newFactory(): PoAcknowledgmentFactory
    {
        return PoAcknowledgmentFactory::new();
    }
}
