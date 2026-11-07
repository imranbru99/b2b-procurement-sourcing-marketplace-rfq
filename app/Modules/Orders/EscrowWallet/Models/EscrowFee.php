<?php

namespace App\Modules\Orders\EscrowWallet\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Orders\EscrowWallet\Database\Factories\EscrowFeeFactory;

class EscrowFee extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'escrow_fees';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'rate' => 'decimal:2',
  'amount' => 'decimal:2',
);
    }

    protected static function newFactory(): EscrowFeeFactory
    {
        return EscrowFeeFactory::new();
    }
}
