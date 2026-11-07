<?php

namespace App\Modules\Suppliers\Support\Filament;

use Filament\Resources\Resource;

abstract class BaseSupplierResource extends Resource
{
    protected static ?string $navigationGroup = 'Supplier Discovery';
}
