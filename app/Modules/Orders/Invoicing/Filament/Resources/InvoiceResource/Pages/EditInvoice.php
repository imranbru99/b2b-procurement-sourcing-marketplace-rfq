<?php

namespace App\Modules\Orders\Invoicing\Filament\Resources\InvoiceResource\Pages;

use App\Modules\Orders\Invoicing\Filament\Resources\InvoiceResource;
use Filament\Resources\Pages\EditRecord;

class EditInvoice extends EditRecord
{
    protected static string $resource = InvoiceResource::class;
}
