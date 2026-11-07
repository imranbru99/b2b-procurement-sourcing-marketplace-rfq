<?php

namespace App\Modules\Core\Settings\Database\Factories;

use App\Models\Organization;
use App\Modules\Core\Settings\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Setting>
 */
class SettingFactory extends Factory
{
    protected $model = Setting::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'group' => 'general',
            'key' => fake()->unique()->slug(2),
            'value' => ['text' => fake()->sentence()],
            'is_locked' => false,
        ];
    }

    public function platform(): static
    {
        return $this->state(fn (): array => [
            'organization_id' => null,
        ]);
    }

    public function locked(): static
    {
        return $this->state(fn (): array => [
            'is_locked' => true,
        ]);
    }
}
