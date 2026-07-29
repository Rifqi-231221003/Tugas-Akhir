<?php

namespace App\Providers\Filament;

use Filament\Auth\MultiFactor\Email\EmailAuthentication;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->profile()
            ->multiFactorAuthentication([
                EmailAuthentication::make()
                    ->codeExpiryMinutes(5), // berlaku 5 menit
            ])

            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                
            ])
            // Navigation Groups
            ->navigationGroups([
                NavigationGroup::make('MENU')
                    ->collapsible(true),
                NavigationGroup::make('ORDER')
                    ->collapsible(true),
            ])
            // Navigation Items
            ->navigationItems([
                // ========== MENU MAIN ==========
                NavigationItem::make('User')
                    ->icon('heroicon-o-users')
                    ->url('/admin/users')
                    ->sort(2)
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.users.*') 
                        || request()->url() === url('/admin/users')),  // 👈 TAMBAHKAN INI
                
                // ========== MENU MENU ==========
                NavigationItem::make('Product')
                    ->icon('heroicon-o-shopping-bag')
                    ->url('/admin/products')
                    ->group('MENU')  
                    ->sort(1)
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.products.*')
                        || request()->url() === url('/admin/products')),  // 👈 TAMBAHKAN INI
                
                NavigationItem::make('Exchange Rate')
                    ->icon('heroicon-o-currency-dollar')
                    ->url('/admin/exchanges')
                    ->group('MENU')  
                    ->sort(2)
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.exchange-rates.*')
                        || request()->url() === url('/admin/exchanges')),  // 👈 TAMBAHKAN INI
                
                NavigationItem::make('Blockchain')
                    ->icon('heroicon-o-circle-stack')
                    ->url('/admin/blockchains')
                    ->group('MENU')  
                    ->sort(3)
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.blockchains.*')
                        || request()->url() === url('/admin/blockchains')),  // 👈 TAMBAHKAN INI
                
                // ========== MENU ORDER ==========
                NavigationItem::make('Payment Method')
                    ->icon('heroicon-o-credit-card')
                    ->url('/admin/payment-methods')
                    ->group('ORDER') 
                    ->sort(1)
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.payment-methods.*')
                        || request()->url() === url('/admin/payment-methods')),  // 👈 TAMBAHKAN INI
                
                NavigationItem::make('Transaction')
                    ->icon('heroicon-o-banknotes')
                    ->url('/admin/transactions')
                    ->group('ORDER')  
                    ->sort(2)
                    ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.resources.transactions.*')
                        || request()->url() === url('/admin/transactions')),  // 👈 TAMBAHKAN INI
            ])
            ->renderHook(
                'panels::footer',
                fn () => ''
            )
            ->renderHook(
                'panels::head.start',
                function () {
                }
            )
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