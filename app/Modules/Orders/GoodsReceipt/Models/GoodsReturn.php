<?php

namespace App\Modules\Orders\GoodsReceipt\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Orders\GoodsReceipt\Database\Factories\GoodsReturnFactory;

class GoodsReturn extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'goods_returns';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'quantity' => 'decimal:2',
);
    }

    protected static function newFactory(): GoodsReturnFactory
    {
        return GoodsReturnFactory::new();
    }
}
