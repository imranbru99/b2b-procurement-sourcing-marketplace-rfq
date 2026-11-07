<?php

namespace App\Modules\Platform\Helpdesk\Database\Factories;

use App\Modules\Platform\Helpdesk\Models\Ticket;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Ticket> */
class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        return [
            'subject' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'status' => 'open',
            'priority' => 'normal',
        ];
    }
}
