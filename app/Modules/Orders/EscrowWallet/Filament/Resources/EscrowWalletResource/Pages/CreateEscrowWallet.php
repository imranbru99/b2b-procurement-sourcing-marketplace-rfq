<?php

namespace App\Modules\Orders\EscrowWallet\Filament\Resources\EscrowWalletResource\Pages;

use App\Modules\Orders\EscrowWallet\Filament\Resources\EscrowWalletResource;
use Filament\Resources\Pages\CreateRecord;

class CreateEscrowWallet extends CreateRecord
{
    protected static string $resource = EscrowWalletResource::class;
}
