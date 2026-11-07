<?php

namespace App\Modules\Platform\DataImportExport\Database\Factories;

use App\Modules\Platform\DataImportExport\Models\ImportJob;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<ImportJob> */
class ImportJobFactory extends Factory
{
    protected $model = ImportJob::class;

    public function definition(): array
    {
        return [
            'type' => 'suppliers',
            'status' => 'pending',
            'stats' => [],
        ];
    }
}
