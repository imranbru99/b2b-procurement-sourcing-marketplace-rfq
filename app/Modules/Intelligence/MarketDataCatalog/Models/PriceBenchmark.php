<?php

namespace App\Modules\Intelligence\MarketDataCatalog\Models;

use App\Models\Concerns\BelongsToOrganization;
use App\Modules\Intelligence\MarketDataCatalog\Database\Factories\PriceBenchmarkFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceBenchmark extends Model
{
    use BelongsToOrganization;
    use HasFactory;

    protected $table = 'price_benchmarks';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'meta' => 'array',
            'median_price' => 'decimal:4',
            'p25_price' => 'decimal:4',
            'p75_price' => 'decimal:4',
        ];
    }

    protected static function newFactory(): PriceBenchmarkFactory
    {
        return PriceBenchmarkFactory::new();
    }
}
