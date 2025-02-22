<?php

namespace App\Providers;

use App\Models\MediaModel;
use App\Observers\MediaObserver;
use Illuminate\Support\ServiceProvider;
use Reverb\Reverb;

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
        // MediaModel::observe(MediaObserver::class);
        // Reverb::routes();
    }
}
