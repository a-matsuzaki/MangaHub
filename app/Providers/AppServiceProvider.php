<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // if (config('app.force_ssl')) {
        //     \URL::forceScheme('https');
        // }

        View::composer('layouts.mangahub_navigation', function ($view) {
            if (Auth::check()) { // ユーザーがログインしている場合
                $ownedVolumesCount = Auth::user()->mangaVolumes()->count();
                $view->with('ownedVolumesCount', $ownedVolumesCount);
            }
        });
    }
}
