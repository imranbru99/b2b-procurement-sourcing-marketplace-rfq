<?php

namespace App\Modules\Orders\Disputes\Filament\Resources\DisputeResource\Pages;

use App\Modules\Orders\Disputes\Filament\Resources\DisputeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDispute extends CreateRecord
{
    protected static string $resource = DisputeResource::class;
}
