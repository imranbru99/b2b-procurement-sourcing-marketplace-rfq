<?php

namespace App\Modules\Intelligence\MarketDataCatalog\Filament\Resources\ScrapedCatalogItemResource\Pages;

use App\Modules\Intelligence\MarketDataCatalog\Filament\Resources\ScrapedCatalogItemResource;
use Filament\Resources\Pages\ListRecords;

class ListScrapedCatalogItems extends ListRecords
{
    protected static string $resource = ScrapedCatalogItemResource::class;
}
