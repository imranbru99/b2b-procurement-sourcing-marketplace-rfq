<?php

namespace App\Modules\Operations\InventoryLite\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Operations\InventoryLite\Database\Factories\InventoryItemFactory;

class InventoryItem extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'inventory_items';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
);
    }

    protected static function newFactory(): InventoryItemFactory
    {
        return InventoryItemFactory::new();
    }
}
