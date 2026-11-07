<?php

namespace App\Modules\Operations\Logistics\Models;

use App\Models\Concerns\BelongsToOrganization;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Operations\Logistics\Database\Factories\FreightQuoteFactory;

class FreightQuote extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'freight_quotes';

    protected $guarded = ["id"];

    protected function casts(): array
    {
        return array (
  'amount' => 'decimal:2',
);
    }

    protected static function newFactory(): FreightQuoteFactory
    {
        return FreightQuoteFactory::new();
    }
}
