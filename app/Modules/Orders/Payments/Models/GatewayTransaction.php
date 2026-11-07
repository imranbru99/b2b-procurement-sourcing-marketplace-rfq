<?php

namespace App\Modules\Orders\Payments\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Modules\Orders\Payments\Database\Factories\GatewayTransactionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GatewayTransaction extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'gateway_transactions';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'payload' => 'array',
        ];
    }

    protected static function newFactory(): GatewayTransactionFactory
    {
        return GatewayTransactionFactory::new();
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}
