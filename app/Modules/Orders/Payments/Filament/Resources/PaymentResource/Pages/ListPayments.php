<?php

namespace App\Modules\Orders\Payments\Filament\Resources\PaymentResource\Pages;

use App\Modules\Orders\Payments\Filament\Resources\PaymentResource;
use Filament\Resources\Pages\ListRecords;

class ListPayments extends ListRecords
{
    protected static string $resource = PaymentResource::class;
}
