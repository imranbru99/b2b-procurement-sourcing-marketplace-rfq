<?php

namespace App\Modules\Operations\Messaging\Database\Factories;

use App\Modules\Operations\Messaging\Models\MessageMention;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MessageMention>
 */
class MessageMentionFactory extends Factory
{
    protected $model = MessageMention::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
