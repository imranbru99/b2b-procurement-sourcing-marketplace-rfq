<?php

namespace App\Modules\Core\Organizations\Filament\Platform\Resources\OrganizationResource\Pages;

use App\Modules\Core\Organizations\Filament\Platform\Resources\OrganizationResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOrganization extends CreateRecord
{
    protected static string $resource = OrganizationResource::class;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (isset($data['currency'])) {
            $data['settings'] = array_merge($data['settings'] ?? [], [
                'currency' => strtoupper((string) $data['currency']),
            ]);
            unset($data['currency']);
        }

        if (isset($data['status'])) {
            $data['is_active'] = $data['status'] === 'active';
            unset($data['status']);
        }

        return $data;
    }
}
