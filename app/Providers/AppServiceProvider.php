<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema; // Tambahkan ini
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::useTailwind();

        // SHARE SETTING KE SEMUA VIEW
        // Cek dulu apakah tabel settings sudah ada (untuk menghindari error saat migrate fresh)
        if (Schema::hasTable('settings')) {
            $web_config = Setting::pluck('value', 'key')->toArray();
            View::share('web_config', $web_config);
        }
    }
}