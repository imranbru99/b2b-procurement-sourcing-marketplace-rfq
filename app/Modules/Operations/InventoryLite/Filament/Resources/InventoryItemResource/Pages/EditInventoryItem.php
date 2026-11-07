<?php

namespace App\Modules\Operations\InventoryLite\Filament\Resources\InventoryItemResource\Pages;

use App\Modules\Operations\InventoryLite\Filament\Resources\InventoryItemResource;
use Filament\Resources\Pages\EditRecord;

class EditInventoryItem extends EditRecord
{
    protected static string $resource = InventoryItemResource::class;
}
