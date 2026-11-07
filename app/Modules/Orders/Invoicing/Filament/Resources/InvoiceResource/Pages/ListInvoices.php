<?php

namespace App\Modules\Orders\Invoicing\Filament\Resources\InvoiceResource\Pages;

use App\Modules\Orders\Invoicing\Filament\Resources\InvoiceResource;
use Filament\Resources\Pages\ListRecords;

class ListInvoices extends ListRecords
{
    protected static string $resource = InvoiceResource::class;
}
