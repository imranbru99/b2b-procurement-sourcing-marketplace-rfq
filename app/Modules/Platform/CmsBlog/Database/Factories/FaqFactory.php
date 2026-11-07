<?php

namespace App\Modules\Platform\CmsBlog\Database\Factories;

use App\Modules\Platform\CmsBlog\Models\Faq;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Faq> */
class FaqFactory extends Factory
{
    protected $model = Faq::class;

    public function definition(): array
    {
        return [
            'question' => fake()->sentence(3),
            'meta_title' => fake()->sentence(4),
            'meta_description' => fake()->sentence(8),
            'content' => ['en' => fake()->paragraph()],
            'is_published' => true,
        ];
    }
}
