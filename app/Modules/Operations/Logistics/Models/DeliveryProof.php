<?php

namespace App\Modules\Operations\Logistics\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Operations\Logistics\Database\Factories\DeliveryProofFactory;

class DeliveryProof extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'delivery_proofs';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'delivered_at' => 'datetime',
);
    }

    protected static function newFactory(): DeliveryProofFactory
    {
        return DeliveryProofFactory::new();
    }
}
