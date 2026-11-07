<?php

namespace App\Modules\Orders\PurchaseOrders\Filament\Resources\PurchaseOrderResource\Pages;

use App\Modules\Orders\PurchaseOrders\Filament\Resources\PurchaseOrderResource;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseOrder extends EditRecord
{
    protected static string $resource = PurchaseOrderResource::class;
}
