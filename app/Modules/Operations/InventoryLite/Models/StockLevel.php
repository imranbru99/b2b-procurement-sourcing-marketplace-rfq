<?php

namespace App\Modules\Operations\InventoryLite\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Operations\InventoryLite\Database\Factories\StockLevelFactory;

class StockLevel extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'stock_levels';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'quantity_on_hand' => 'decimal:2',
);
    }

    protected static function newFactory(): StockLevelFactory
    {
        return StockLevelFactory::new();
    }
}
