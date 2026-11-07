<?php

namespace App\Modules\Suppliers\Catalog\Filament\Supplier\Resources\ProductResource\Pages;

use App\Modules\Suppliers\Catalog\Filament\Supplier\Resources\ProductResource;
use Filament\Resources\Pages\ListRecords;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;
}
