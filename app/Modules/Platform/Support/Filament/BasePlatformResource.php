<?php

namespace App\Modules\Platform\Support\Filament;

use Filament\Resources\Resource;

abstract class BasePlatformResource extends Resource
{
    protected static ?string $navigationGroup = 'Platform';
}
