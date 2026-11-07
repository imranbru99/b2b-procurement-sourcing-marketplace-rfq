<?php

namespace App\Modules\Core\Users\Filament\Platform\Resources\UserResource\Pages;

use App\Modules\Core\Users\Filament\Platform\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
