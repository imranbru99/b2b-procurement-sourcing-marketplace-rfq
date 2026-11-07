<?php

namespace App\Modules\Platform\SecurityCenter\Filament\Platform\Resources\IpAllowlistResource\Pages;

use App\Modules\Platform\SecurityCenter\Filament\Platform\Resources\IpAllowlistResource;
use Filament\Resources\Pages\ListRecords;

class ListIpAllowlists extends ListRecords
{
    protected static string $resource = IpAllowlistResource::class;
}
