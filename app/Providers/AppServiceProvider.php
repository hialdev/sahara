<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Load Setting 
        $getSet = Setting::all()->keyBy('the_key');
        View::share('getSet', $getSet);

        // Load file helper jika ada
        if (File::exists(app_path('helpers.php'))) {
            require_once app_path('helpers.php');
        }
    }
}
