<?php

namespace App\Modules\Core\Organizations\Filament\Admin\Resources\OrganizationResource\Pages;

use App\Modules\Core\Organizations\Filament\Admin\Resources\OrganizationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrganizations extends ListRecords
{
    protected static string $resource = OrganizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
