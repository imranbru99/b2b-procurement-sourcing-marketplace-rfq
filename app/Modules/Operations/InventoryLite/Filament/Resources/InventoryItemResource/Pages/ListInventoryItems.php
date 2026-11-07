<?php

namespace App\Modules\Operations\InventoryLite\Filament\Resources\InventoryItemResource\Pages;

use App\Modules\Operations\InventoryLite\Filament\Resources\InventoryItemResource;
use Filament\Resources\Pages\ListRecords;

class ListInventoryItems extends ListRecords
{
    protected static string $resource = InventoryItemResource::class;
}
