<?php

namespace App\Modules\Orders\Disputes\Filament\Resources\DisputeResource\Pages;

use App\Modules\Orders\Disputes\Filament\Resources\DisputeResource;
use Filament\Resources\Pages\ListRecords;

class ListDisputes extends ListRecords
{
    protected static string $resource = DisputeResource::class;
}
