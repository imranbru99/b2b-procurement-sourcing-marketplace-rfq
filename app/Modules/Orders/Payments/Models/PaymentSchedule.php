<?php

namespace App\Modules\Orders\Payments\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Orders\Payments\Database\Factories\PaymentScheduleFactory;

class PaymentSchedule extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'payment_schedules';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'due_at' => 'datetime',
  'amount' => 'decimal:2',
);
    }

    protected static function newFactory(): PaymentScheduleFactory
    {
        return PaymentScheduleFactory::new();
    }
}
