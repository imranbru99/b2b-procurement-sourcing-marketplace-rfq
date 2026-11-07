<?php

namespace App\Modules\Orders\Payments\Filament\Resources\PaymentResource\Pages;

use App\Modules\Orders\Payments\Filament\Resources\PaymentResource;
use Filament\Resources\Pages\EditRecord;

class EditPayment extends EditRecord
{
    protected static string $resource = PaymentResource::class;
}
