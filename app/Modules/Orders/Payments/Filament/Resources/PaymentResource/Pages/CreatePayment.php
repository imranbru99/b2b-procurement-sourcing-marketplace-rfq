<?php

namespace App\Modules\Orders\Payments\Filament\Resources\PaymentResource\Pages;

use App\Modules\Orders\Payments\Filament\Resources\PaymentResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;
}
