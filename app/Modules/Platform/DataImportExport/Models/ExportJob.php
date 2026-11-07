<?php

namespace App\Modules\Platform\DataImportExport\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\DataImportExport\Database\Factories\ExportJobFactory;
use App\Models\Concerns\BelongsToOrganization;

class ExportJob extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $table = 'data_export_jobs';

    protected $guarded = [];

    protected function casts(): array
    {
        return ['stats' => 'array'];
    }

    protected static function newFactory(): ExportJobFactory
    {
        return ExportJobFactory::new();
    }
}
