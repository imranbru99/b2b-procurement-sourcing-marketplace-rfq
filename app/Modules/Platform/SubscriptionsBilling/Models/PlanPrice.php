<?php

namespace App\Modules\Platform\SubscriptionsBilling\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\SubscriptionsBilling\Database\Factories\PlanPriceFactory;

class PlanPrice extends Model
{
    use HasFactory;

    protected $table = 'subscription_plan_prices';

    protected $guarded = [];

    protected static function newFactory(): PlanPriceFactory
    {
        return PlanPriceFactory::new();
    }
}
