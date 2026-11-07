<?php

namespace App\Modules\Orders\Payments\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Orders\Payments\Database\Factories\PaymentProofFactory;

class PaymentProof extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'payment_proofs';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'uploaded_at' => 'datetime',
);
    }

    protected static function newFactory(): PaymentProofFactory
    {
        return PaymentProofFactory::new();
    }
}
