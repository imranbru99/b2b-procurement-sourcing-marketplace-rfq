<?php

namespace App\Modules\Orders\Invoicing\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Orders\Invoicing\Database\Factories\InvoiceItemFactory;

class InvoiceItem extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'invoice_items';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'quantity' => 'decimal:2',
  'unit_price' => 'decimal:2',
  'line_total' => 'decimal:2',
);
    }

    protected static function newFactory(): InvoiceItemFactory
    {
        return InvoiceItemFactory::new();
    }
}
