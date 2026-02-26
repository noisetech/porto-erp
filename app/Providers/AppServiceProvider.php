<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Interfaces\SubKategoriAnggaranRepositoryInterface::class,
            \App\Repositories\SubKategoriAnggaranRepository::class
        );

        $this->app->bind(
            \App\Repositories\Interfaces\KategoriAnggaranRepositoryInterface::class,
            \App\Repositories\KategoriAnggaranRepository::class

        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        config(['app.locale' => 'id']);
        Carbon::setlocale('id');
        date_default_timezone_set('Asia/Jakarta');
    }
}
