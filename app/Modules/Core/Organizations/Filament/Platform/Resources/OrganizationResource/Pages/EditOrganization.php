<?php

namespace App\Modules\Core\Organizations\Filament\Platform\Resources\OrganizationResource\Pages;

use App\Modules\Core\Organizations\Filament\Platform\Resources\OrganizationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrganization extends EditRecord
{
    protected static string $resource = OrganizationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (isset($data['currency'])) {
            $settings = $this->record->settings ?? [];
            $settings['currency'] = strtoupper((string) $data['currency']);
            $data['settings'] = $settings;
            unset($data['currency']);
        }

        if (isset($data['status'])) {
            $data['is_active'] = $data['status'] === 'active';
            unset($data['status']);
        }

        return $data;
    }
}
