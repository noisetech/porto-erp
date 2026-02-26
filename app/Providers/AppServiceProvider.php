<?php

namespace App\Providers;

use App\Repositories\Adapter\KategoriAnggaranRepository;
use App\Repositories\Adapter\SubKategoriAnggaranRepository;
use App\Repositories\Interfaces\KategoriAnggaranRepositoryInterface;
use App\Repositories\Interfaces\SubKategoriAnggaranRepositoryInterface;
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
            SubKategoriAnggaranRepositoryInterface::class,
            SubKategoriAnggaranRepository::class
        );
        $this->app->bind(
            KategoriAnggaranRepositoryInterface::class,
            KategoriAnggaranRepository::class
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
