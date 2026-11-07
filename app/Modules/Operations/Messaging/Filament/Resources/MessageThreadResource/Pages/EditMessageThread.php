<?php

namespace App\Modules\Operations\Messaging\Filament\Resources\MessageThreadResource\Pages;

use App\Modules\Operations\Messaging\Filament\Resources\MessageThreadResource;
use Filament\Resources\Pages\EditRecord;

class EditMessageThread extends EditRecord
{
    protected static string $resource = MessageThreadResource::class;
}
