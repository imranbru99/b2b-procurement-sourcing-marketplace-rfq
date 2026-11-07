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

class BuyerPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('buyer')
            ->path('buyer')
            ->login()
            ->brandName('Buyer Portal')
            ->colors([
                'primary' => Color::Blue,
            ])
            ->discoverResources(in: app_path('Filament/Buyer/Resources'), for: 'App\\Filament\\Buyer\\Resources')
            ->discoverResources(in: app_path('Modules/Sourcing'), for: 'App\\Modules\\Sourcing')
            ->discoverResources(in: app_path('Modules/Orders'), for: 'App\\Modules\\Orders')
            ->discoverResources(in: app_path('Modules/Operations'), for: 'App\\Modules\\Operations')
            ->discoverResources(in: app_path('Modules/Suppliers'), for: 'App\\Modules\\Suppliers')
            ->discoverResources(in: app_path('Modules/Intelligence'), for: 'App\\Modules\\Intelligence')
            ->discoverResources(in: app_path('Modules/Core'), for: 'App\\Modules\\Core')
            ->discoverPages(in: app_path('Filament/Buyer/Pages'), for: 'App\\Filament\\Buyer\\Pages')
            ->discoverPages(in: app_path('Modules/Core'), for: 'App\\Modules\\Core')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Buyer/Widgets'), for: 'App\\Filament\\Buyer\\Widgets')
            ->discoverWidgets(in: app_path('Modules/Core/Dashboard'), for: 'App\\Modules\\Core\\Dashboard')
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
