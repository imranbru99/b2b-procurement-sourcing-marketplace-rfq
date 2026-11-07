<?php

namespace App\Modules\Platform\SecurityCenter\Database\Factories;

use App\Modules\Platform\SecurityCenter\Models\SecuritySetting;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<SecuritySetting> */
class SecuritySettingFactory extends Factory
{
    protected $model = SecuritySetting::class;

    public function definition(): array
    {
        return [
            'settings' => ['mfa_required' => false],
        ];
    }
}
