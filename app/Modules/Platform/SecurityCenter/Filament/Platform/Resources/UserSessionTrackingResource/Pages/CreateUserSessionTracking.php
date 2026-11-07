<?php

namespace App\Modules\Platform\SecurityCenter\Filament\Platform\Resources\UserSessionTrackingResource\Pages;

use App\Modules\Platform\SecurityCenter\Filament\Platform\Resources\UserSessionTrackingResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserSessionTracking extends CreateRecord
{
    protected static string $resource = UserSessionTrackingResource::class;
}
