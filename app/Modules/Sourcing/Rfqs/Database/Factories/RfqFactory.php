<?php

namespace App\Modules\Sourcing\Rfqs\Database\Factories;

use App\Modules\Sourcing\Rfqs\Models\Rfq;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rfq>
 */
class RfqFactory extends Factory
{
    protected $model = Rfq::class;

    public function definition(): array
    {
        $title = fake()->sentence(4);

        return [
            'organization_id' => \App\Models\Organization::factory(),
            'type' => 'rfq',
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title).'-'.fake()->unique()->numerify('####'),
            'visibility' => 'private',
            'status' => 'draft',
            'deadline' => now()->addDays(14),
            'incoterms' => 'FOB',
            'payment_terms' => 'Net 30',
            'delivery_terms' => 'Standard',
            'version' => 1,
        ];
    }

    public function open(): static
    {
        return $this->state(fn () => ['status' => 'open']);
    }
}
