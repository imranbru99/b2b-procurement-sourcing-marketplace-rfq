<?php

namespace App\Modules\Platform\SubscriptionsBilling\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\SubscriptionsBilling\Database\Factories\CouponPlatformFactory;

class CouponPlatform extends Model
{
    use HasFactory;

    protected $table = 'coupons_platform';

    protected $guarded = [];

    protected static function newFactory(): CouponPlatformFactory
    {
        return CouponPlatformFactory::new();
    }
}
