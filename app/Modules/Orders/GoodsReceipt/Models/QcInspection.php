<?php

namespace App\Modules\Orders\GoodsReceipt\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Orders\GoodsReceipt\Database\Factories\QcInspectionFactory;

class QcInspection extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'qc_inspections';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'passed' => 'boolean',
  'inspected_at' => 'datetime',
);
    }

    protected static function newFactory(): QcInspectionFactory
    {
        return QcInspectionFactory::new();
    }
}
