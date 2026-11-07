<?php

namespace App\Modules\Orders\PurchaseOrders\Filament\Resources\PurchaseOrderResource\Pages;

use App\Modules\Orders\PurchaseOrders\Filament\Resources\PurchaseOrderResource;
use Filament\Resources\Pages\ListRecords;

class ListPurchaseOrders extends ListRecords
{
    protected static string $resource = PurchaseOrderResource::class;
}
