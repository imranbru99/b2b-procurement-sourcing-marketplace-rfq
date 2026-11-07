<?php

namespace App\Modules\Core\Users\Filament\Admin\Resources\UserResource\Pages;

use App\Modules\Core\Users\Filament\Admin\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    /** @var list<string> */
    protected array $roleNames = [];

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $this->roleNames = array_values($data['roles'] ?? []);
        unset($data['roles']);

        return $data;
    }

    protected function afterCreate(): void
    {
        if ($this->roleNames !== []) {
            $this->record->syncRoles($this->roleNames);
        }
    }
}
