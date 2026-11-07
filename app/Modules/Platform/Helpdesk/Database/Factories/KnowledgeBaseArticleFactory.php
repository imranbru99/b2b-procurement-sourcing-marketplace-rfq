<?php

namespace App\Modules\Platform\Helpdesk\Database\Factories;

use App\Modules\Platform\Helpdesk\Models\KnowledgeBaseArticle;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<KnowledgeBaseArticle> */
class KnowledgeBaseArticleFactory extends Factory
{
    protected $model = KnowledgeBaseArticle::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'content' => fake()->paragraph(),
            'category' => 'general',
        ];
    }
}
