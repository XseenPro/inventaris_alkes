<?php

namespace App\Providers;

use Filament\Facades\Filament;
use Illuminate\Support\ServiceProvider;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Livewire\FloatingNotification;
use NotificationChannels\Telegram\Telegram;
use GuzzleHttp\Client as GuzzleClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(Telegram::class, function () {
        return new Telegram(
            config('services.telegram-bot-api.token'),

            new GuzzleClient([
                'base_uri' => 'https://api.telegram.org',
                'verify'   => false, // DEV ONLY
                'timeout'  => 10,
            ]),
        );
    });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentView::registerRenderHook(
          'panels::sidebar.nav.start',
          fn()=>view('filament.components.sidebar-header')
        );

        FilamentView::registerRenderHook(
          'panels::sidebar.footer',
          fn()=>view('filament.components.sidebar-footer')
        );

        // FilamentView::registerRenderHook(
        //   'panels::body.end',
        //   fn()=>\Livewire\Livewire::mount(FloatingNotification::class)
        // );
    }

    
}
