<?php

namespace App\Modules\Operations\Messaging\Database\Factories;

use App\Modules\Operations\Messaging\Models\MessageThread;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MessageThread>
 */
class MessageThreadFactory extends Factory
{
    protected $model = MessageThread::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
        ];
    }
}
