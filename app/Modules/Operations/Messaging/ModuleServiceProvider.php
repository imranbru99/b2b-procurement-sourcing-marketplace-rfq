<?php

namespace App\Modules\Operations\Messaging;

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
  'App\\Modules\\Operations\\Messaging\\Models\\MessageThread' => 'App\\Modules\\Operations\\Messaging\\Policies\\MessageThreadPolicy',
  'App\\Modules\\Operations\\Messaging\\Models\\Message' => 'App\\Modules\\Operations\\Messaging\\Policies\\MessagePolicy',
  'App\\Modules\\Operations\\Messaging\\Models\\MessageMention' => 'App\\Modules\\Operations\\Messaging\\Policies\\MessageMentionPolicy',
);

        $this->bootModulePolicies($policies);

        $this->registerBuyerFilamentResources([
            \App\Modules\Operations\Messaging\Filament\Resources\MessageThreadResource::class,
        ]);
    }
}
