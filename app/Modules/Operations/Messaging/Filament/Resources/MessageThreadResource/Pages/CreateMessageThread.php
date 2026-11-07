<?php

namespace App\Modules\Operations\Messaging\Filament\Resources\MessageThreadResource\Pages;

use App\Modules\Operations\Messaging\Filament\Resources\MessageThreadResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMessageThread extends CreateRecord
{
    protected static string $resource = MessageThreadResource::class;
}
