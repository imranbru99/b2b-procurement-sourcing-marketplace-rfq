<?php

namespace App\Modules\Operations\Logistics;

use App\Modules\Operations\Concerns\BootsModuleResources;
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
  'App\\Modules\\Operations\\Logistics\\Models\\Carrier' => 'App\\Modules\\Operations\\Logistics\\Policies\\CarrierPolicy',
  'App\\Modules\\Operations\\Logistics\\Models\\Shipment' => 'App\\Modules\\Operations\\Logistics\\Policies\\ShipmentPolicy',
  'App\\Modules\\Operations\\Logistics\\Models\\TrackingEvent' => 'App\\Modules\\Operations\\Logistics\\Policies\\TrackingEventPolicy',
  'App\\Modules\\Operations\\Logistics\\Models\\FreightQuote' => 'App\\Modules\\Operations\\Logistics\\Policies\\FreightQuotePolicy',
  'App\\Modules\\Operations\\Logistics\\Models\\DeliveryProof' => 'App\\Modules\\Operations\\Logistics\\Policies\\DeliveryProofPolicy',
);

        $this->bootModulePolicies($policies);

        $this->registerBuyerFilamentResources([
            \App\Modules\Operations\Logistics\Filament\Resources\ShipmentResource::class,
        ]);
    }
}
