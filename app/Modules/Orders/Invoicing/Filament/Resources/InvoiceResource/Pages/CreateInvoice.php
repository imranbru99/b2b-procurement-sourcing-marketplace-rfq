<?php

namespace App\Modules\Orders\Invoicing\Filament\Resources\InvoiceResource\Pages;

use App\Modules\Orders\Invoicing\Filament\Resources\InvoiceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInvoice extends CreateRecord
{
    protected static string $resource = InvoiceResource::class;
}
