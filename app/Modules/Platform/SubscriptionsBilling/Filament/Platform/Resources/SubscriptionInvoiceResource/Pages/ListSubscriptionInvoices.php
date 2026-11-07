<?php

namespace App\Modules\Platform\SubscriptionsBilling\Filament\Platform\Resources\SubscriptionInvoiceResource\Pages;

use App\Modules\Platform\SubscriptionsBilling\Filament\Platform\Resources\SubscriptionInvoiceResource;
use Filament\Resources\Pages\ListRecords;

class ListSubscriptionInvoices extends ListRecords
{
    protected static string $resource = SubscriptionInvoiceResource::class;
}
