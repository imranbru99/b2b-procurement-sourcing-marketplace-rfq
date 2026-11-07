<?php

namespace App\Modules\Core\Users\Filament\Admin\Resources\UserResource\Pages;

use App\Modules\Core\Users\Filament\Admin\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    /** @var list<string> */
    protected array $roleNames = [];

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
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['roles'] = $this->record->getRoleNames()->all();

        return $data;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->roleNames = array_values($data['roles'] ?? []);
        unset($data['roles']);

        return $data;
    }

    protected function afterSave(): void
    {
        $this->record->syncRoles($this->roleNames);
    }
}
