<?php

namespace App\Modules\Orders\EscrowWallet;

use App\Modules\Orders\Concerns\BootsModuleResources;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    use BootsModuleResources;

    public function register(): void
    {
        
    }

    public function boot(): void
    {
        $this->bootModuleMigrations();

        $policies = array (
  'App\\Modules\\Orders\\EscrowWallet\\Models\\EscrowWallet' => 'App\\Modules\\Orders\\EscrowWallet\\Policies\\EscrowWalletPolicy',
  'App\\Modules\\Orders\\EscrowWallet\\Models\\WalletTransaction' => 'App\\Modules\\Orders\\EscrowWallet\\Policies\\WalletTransactionPolicy',
  'App\\Modules\\Orders\\EscrowWallet\\Models\\EscrowMilestone' => 'App\\Modules\\Orders\\EscrowWallet\\Policies\\EscrowMilestonePolicy',
  'App\\Modules\\Orders\\EscrowWallet\\Models\\EscrowFee' => 'App\\Modules\\Orders\\EscrowWallet\\Policies\\EscrowFeePolicy',
);

        $this->bootModulePolicies($policies);

        $this->registerBuyerFilamentResources([
            \App\Modules\Orders\EscrowWallet\Filament\Resources\EscrowWalletResource::class,
        ]);
    }
}
