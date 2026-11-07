<?php

namespace App\Modules\Operations\InventoryLite\Filament\Resources\InventoryItemResource\Pages;

use App\Modules\Operations\InventoryLite\Filament\Resources\InventoryItemResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInventoryItem extends CreateRecord
{
    protected static string $resource = InventoryItemResource::class;
}
