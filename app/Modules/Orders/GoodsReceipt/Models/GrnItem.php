<?php

namespace App\Modules\Orders\GoodsReceipt\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Orders\GoodsReceipt\Database\Factories\GrnItemFactory;

class GrnItem extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'grn_items';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'quantity_received' => 'decimal:2',
  'quantity_accepted' => 'decimal:2',
);
    }

    protected static function newFactory(): GrnItemFactory
    {
        return GrnItemFactory::new();
    }
}
