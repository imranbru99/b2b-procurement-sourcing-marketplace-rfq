<?php

namespace App\Modules\Intelligence\MarketDataCatalog\Models;

use App\Models\Organization;
use App\Modules\Intelligence\MarketDataCatalog\Database\Factories\ScrapedCatalogItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScrapedCatalogItem extends Model
{
    use HasFactory;

    protected $table = 'scraped_catalog_items';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'raw' => 'array',
            'price' => 'decimal:4',
        ];
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    protected static function newFactory(): ScrapedCatalogItemFactory
    {
        return ScrapedCatalogItemFactory::new();
    }
}
