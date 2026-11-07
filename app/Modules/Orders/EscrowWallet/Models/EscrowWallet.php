<?php

namespace App\Modules\Orders\EscrowWallet\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Modules\Orders\EscrowWallet\Database\Factories\EscrowWalletFactory;
use App\Modules\Orders\PurchaseOrders\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EscrowWallet extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'escrow_wallets';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'balance' => 'decimal:2',
        ];
    }

    protected static function newFactory(): EscrowWalletFactory
    {
        return EscrowWalletFactory::new();
    }

    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class, 'purchase_order_id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class, 'escrow_wallet_id');
    }

    public function milestones(): HasMany
    {
        return $this->hasMany(EscrowMilestone::class, 'escrow_wallet_id');
    }

    public function fees(): HasMany
    {
        return $this->hasMany(EscrowFee::class, 'escrow_wallet_id');
    }
}
