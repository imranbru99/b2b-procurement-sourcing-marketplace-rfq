<?php

namespace App\Modules\Platform\DataImportExport\Database\Factories;

use App\Modules\Platform\DataImportExport\Models\ExportJob;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<ExportJob> */
class ExportJobFactory extends Factory
{
    protected $model = ExportJob::class;

    public function definition(): array
    {
        return [
            'type' => 'rfqs',
            'status' => 'pending',
            'stats' => [],
        ];
    }
}
