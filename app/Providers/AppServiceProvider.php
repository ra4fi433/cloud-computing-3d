<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Telegram\Bot\Laravel\Facades\Telegram;
use Illuminate\Support\Facades\URL;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    // public function boot(): void
    // {
    //     Filament::authenticateUsing(function (Request $request): ?\Illuminate\Contracts\Auth\Authenticatable {
    //         if (Auth::attempt([
    //             'name' => $request->name,
    //             'password' => $request->password,
    //         ])) {
    //             return Auth::user();
    //         }

    //         return null;
    //     });
    // }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Filament::authenticateUsing(function (Request $request): ?\Illuminate\Contracts\Auth\Authenticatable {
        //     if (Auth::attempt([
        //         'name' => $request->name,
        //         'password' => $request->password,
        //     ])) {
        //         return Auth::user();
        //     }

        //     return null;
        // });

    //    if (config('app.env') === 'local') {
    //         URL::forceScheme('https');
    //     }

    //   if (config('app.env') === 'local') {
    //    if (config('app.env') === 'local') {
    //         URL::forceScheme('https');
    //     }
    
        // Telegram::setWebhook(['url' => 'https://dukcapil3374.e-agendadukcapil.site/telegram/webhook']);
    }

    
}
