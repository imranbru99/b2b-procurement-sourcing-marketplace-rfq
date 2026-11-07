<?php

namespace App\Modules\Platform\CmsBlog\Database\Factories;

use App\Modules\Platform\CmsBlog\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<BlogPost> */
class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'meta_title' => fake()->sentence(4),
            'meta_description' => fake()->sentence(8),
            'content' => ['en' => fake()->paragraph()],
            'is_published' => true,
        ];
    }
}
