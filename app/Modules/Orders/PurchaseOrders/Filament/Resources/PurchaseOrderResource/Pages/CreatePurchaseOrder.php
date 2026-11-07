<?php

namespace App\Modules\Orders\PurchaseOrders\Filament\Resources\PurchaseOrderResource\Pages;

use App\Modules\Orders\PurchaseOrders\Filament\Resources\PurchaseOrderResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePurchaseOrder extends CreateRecord
{
    protected static string $resource = PurchaseOrderResource::class;
}
