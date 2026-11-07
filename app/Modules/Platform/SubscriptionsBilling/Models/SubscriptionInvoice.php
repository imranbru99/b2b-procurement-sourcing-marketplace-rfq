<?php

namespace App\Modules\Platform\SubscriptionsBilling\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\SubscriptionsBilling\Database\Factories\SubscriptionInvoiceFactory;

class SubscriptionInvoice extends Model
{
    use HasFactory;

    protected $table = 'subscription_invoices';

    protected $guarded = [];

    protected static function newFactory(): SubscriptionInvoiceFactory
    {
        return SubscriptionInvoiceFactory::new();
    }
}
