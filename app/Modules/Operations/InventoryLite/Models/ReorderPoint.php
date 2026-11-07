<?php

namespace App\Modules\Operations\InventoryLite\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Operations\InventoryLite\Database\Factories\ReorderPointFactory;

class ReorderPoint extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'reorder_points';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'minimum_quantity' => 'decimal:2',
  'reorder_quantity' => 'decimal:2',
);
    }

    protected static function newFactory(): ReorderPointFactory
    {
        return ReorderPointFactory::new();
    }
}
