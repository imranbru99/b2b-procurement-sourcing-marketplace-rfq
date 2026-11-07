<?php

namespace App\Modules\Orders\EscrowWallet\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Orders\EscrowWallet\Database\Factories\WalletTransactionFactory;

class WalletTransaction extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'wallet_transactions';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'amount' => 'decimal:2',
  'balance_after' => 'decimal:2',
);
    }

    protected static function newFactory(): WalletTransactionFactory
    {
        return WalletTransactionFactory::new();
    }
}
