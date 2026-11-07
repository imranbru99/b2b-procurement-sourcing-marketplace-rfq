<?php

namespace App\Modules\Intelligence\AnalyticsReporting\Database\Factories;

use App\Models\Organization;
use App\Modules\Intelligence\AnalyticsReporting\Models\SavedReport;
use App\Modules\Intelligence\AnalyticsReporting\Models\ScheduledReportEmail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ScheduledReportEmail>
 */
class ScheduledReportEmailFactory extends Factory
{
    protected $model = ScheduledReportEmail::class;

    public function definition(): array
    {
        return [
            'organization_id' => Organization::factory(),
            'saved_report_id' => SavedReport::factory(),
            'recipient_email' => fake()->safeEmail(),
            'cadence' => 'weekly',
            'send_at' => '09:00:00',
            'is_active' => true,
        ];
    }
}
