<?php

namespace App\Modules\Sourcing\Rfqs\Database\Factories;

use App\Modules\Sourcing\Rfqs\Models\RfqItem;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<RfqItem>
 */
class RfqItemFactory extends Factory
{
    protected $model = RfqItem::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
