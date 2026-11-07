<?php

namespace App\Modules\Platform\Helpdesk\Database\Factories;

use App\Modules\Platform\Helpdesk\Models\TicketReply;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<TicketReply> */
class TicketReplyFactory extends Factory
{
    protected $model = TicketReply::class;

    public function definition(): array
    {
        return [
            'body' => fake()->paragraph(),
            'is_internal' => false,
        ];
    }
}
