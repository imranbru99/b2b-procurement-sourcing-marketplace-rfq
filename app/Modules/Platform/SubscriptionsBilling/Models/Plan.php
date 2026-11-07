<?php

namespace App\Modules\Platform\SubscriptionsBilling\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\SubscriptionsBilling\Database\Factories\PlanFactory;
use ImranDev\UniversalSlug\Attributes\Slug;
use ImranDev\UniversalSlug\Traits\HasUniversalSlug;

#[Slug(from: 'name')]
class Plan extends Model
{
    use HasFactory, HasUniversalSlug;

    protected $table = 'subscription_plans';

    protected $guarded = [];

    protected function casts(): array
    {
        return ['modules' => 'array'];
    }

    protected static function newFactory(): PlanFactory
    {
        return PlanFactory::new();
    }
}
