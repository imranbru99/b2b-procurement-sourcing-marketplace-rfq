<?php

namespace App\Modules\Platform\DataImportExport\Database\Factories;

use App\Modules\Platform\DataImportExport\Models\BackupLog;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<BackupLog> */
class BackupLogFactory extends Factory
{
    protected $model = BackupLog::class;

    public function definition(): array
    {
        return [
            'path' => 'backups/'.fake()->uuid().'.zip',
            'size_bytes' => 1024,
            'status' => 'completed',
        ];
    }
}
