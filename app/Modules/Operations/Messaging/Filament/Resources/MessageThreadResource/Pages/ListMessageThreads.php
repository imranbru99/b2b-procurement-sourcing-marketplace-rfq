<?php

namespace App\Modules\Operations\Messaging\Filament\Resources\MessageThreadResource\Pages;

use App\Modules\Operations\Messaging\Filament\Resources\MessageThreadResource;
use Filament\Resources\Pages\ListRecords;

class ListMessageThreads extends ListRecords
{
    protected static string $resource = MessageThreadResource::class;
}
