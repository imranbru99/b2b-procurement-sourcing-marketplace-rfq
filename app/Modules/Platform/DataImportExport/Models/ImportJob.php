<?php

namespace App\Modules\Platform\DataImportExport\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\DataImportExport\Database\Factories\ImportJobFactory;
use App\Models\Concerns\BelongsToOrganization;

class ImportJob extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $table = 'data_import_jobs';

    protected $guarded = [];

    protected function casts(): array
    {
        return ['stats' => 'array'];
    }

    protected static function newFactory(): ImportJobFactory
    {
        return ImportJobFactory::new();
    }
}
