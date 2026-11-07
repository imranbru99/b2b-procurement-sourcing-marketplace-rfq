<?php

namespace App\Modules\Platform\SubscriptionsBilling\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\SubscriptionsBilling\Database\Factories\UsageLimitFactory;
use App\Models\Concerns\BelongsToOrganization;

class UsageLimit extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $table = 'usage_limits';

    protected $guarded = [];

    protected static function newFactory(): UsageLimitFactory
    {
        return UsageLimitFactory::new();
    }
}
