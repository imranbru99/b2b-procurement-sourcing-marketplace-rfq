<?php

namespace App\Modules\Operations\Logistics\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Operations\Logistics\Database\Factories\ShipmentFactory;

class Shipment extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'shipments';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'shipped_at' => 'datetime',
  'delivered_at' => 'datetime',
);
    }

    protected static function newFactory(): ShipmentFactory
    {
        return ShipmentFactory::new();
    }
}
