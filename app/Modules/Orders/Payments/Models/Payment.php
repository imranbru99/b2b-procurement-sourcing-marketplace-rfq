<?php

namespace App\Modules\Orders\Payments\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Modules\Orders\Invoicing\Models\Invoice;
use App\Modules\Orders\Payments\Database\Factories\PaymentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'payments';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
        ];
    }

    protected static function newFactory(): PaymentFactory
    {
        return PaymentFactory::new();
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function gatewayTransactions(): HasMany
    {
        return $this->hasMany(GatewayTransaction::class, 'payment_id');
    }

    public function proofs(): HasMany
    {
        return $this->hasMany(PaymentProof::class, 'payment_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(PaymentSchedule::class, 'payment_id');
    }
}
