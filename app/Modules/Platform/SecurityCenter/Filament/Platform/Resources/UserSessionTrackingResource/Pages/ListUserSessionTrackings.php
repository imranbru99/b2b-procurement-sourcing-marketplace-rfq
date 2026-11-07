<?php

namespace App\Modules\Platform\SecurityCenter\Filament\Platform\Resources\UserSessionTrackingResource\Pages;

use App\Modules\Platform\SecurityCenter\Filament\Platform\Resources\UserSessionTrackingResource;
use Filament\Resources\Pages\ListRecords;

class ListUserSessionTrackings extends ListRecords
{
    protected static string $resource = UserSessionTrackingResource::class;
}
