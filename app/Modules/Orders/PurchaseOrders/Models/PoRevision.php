<?php

namespace App\Modules\Orders\PurchaseOrders\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Orders\PurchaseOrders\Database\Factories\PoRevisionFactory;

class PoRevision extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'po_revisions';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'snapshot' => 'array',
);
    }

    protected static function newFactory(): PoRevisionFactory
    {
        return PoRevisionFactory::new();
    }
}
