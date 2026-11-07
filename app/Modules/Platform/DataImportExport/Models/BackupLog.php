<?php

namespace App\Modules\Platform\DataImportExport\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Platform\DataImportExport\Database\Factories\BackupLogFactory;
use App\Models\Concerns\BelongsToOrganization;

class BackupLog extends Model
{
    use HasFactory, BelongsToOrganization;

    protected $table = 'data_backup_logs';

    protected $guarded = [];

    protected static function newFactory(): BackupLogFactory
    {
        return BackupLogFactory::new();
    }
}
