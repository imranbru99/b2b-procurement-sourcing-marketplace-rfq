<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class SupplierPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('supplier')
            ->path('supplier')
            ->login()
            ->brandName('Supplier Portal')
            ->colors([
                'primary' => Color::Emerald,
            ])
            ->discoverResources(in: app_path('Filament/Supplier/Resources'), for: 'App\\Filament\\Supplier\\Resources')
            ->discoverResources(in: app_path('Modules/Suppliers'), for: 'App\\Modules\\Suppliers')
            ->discoverResources(in: app_path('Modules/Sourcing'), for: 'App\\Modules\\Sourcing')
            ->discoverResources(in: app_path('Modules/Orders'), for: 'App\\Modules\\Orders')
            ->discoverResources(in: app_path('Modules/Operations'), for: 'App\\Modules\\Operations')
            ->discoverPages(in: app_path('Filament/Supplier/Pages'), for: 'App\\Filament\\Supplier\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Supplier/Widgets'), for: 'App\\Filament\\Supplier\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
