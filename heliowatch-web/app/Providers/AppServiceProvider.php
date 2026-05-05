<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

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
        // Bagikan variabel ke semua halaman (global)
        View::composer('*', function ($view) {
            
            // Gunakan Cache agar tidak memberatkan Database (Query 1x saja)
            $globalSettings = Cache::rememberForever('global_settings', function () {
                try {
                    return Setting::pluck('value', 'key')->toArray();
                } catch (\Exception $e) {
                    // Fallback jika tabel setting belum di-migrate
                    return []; 
                }
            });

            // Lempar variabel settings utuh ke seluruh Blade
            $view->with('globalSettings', $globalSettings);
            
            // Lempar juga variabel spesifik (opsional, untuk kemudahan)
            $view->with('appTheme', $globalSettings['theme'] ?? 'light');
            $view->with('appRefreshInterval', $globalSettings['refresh_interval'] ?? '30');
            $view->with('appTimezone', $globalSettings['timezone'] ?? 'Asia/Jakarta');
        });
    }
}