<?php

namespace App\Modules\Suppliers\Catalog\Filament\Supplier\Resources\ProductResource\Pages;

use App\Modules\Suppliers\Catalog\Filament\Supplier\Resources\ProductResource;
use Filament\Resources\Pages\EditRecord;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;
}
