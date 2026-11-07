<?php

namespace App\Modules\Suppliers\Catalog\Filament\Platform\Resources\ProductResource\Pages;

use App\Modules\Suppliers\Catalog\Filament\Platform\Resources\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
}
