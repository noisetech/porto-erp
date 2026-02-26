<?php

namespace App\Providers;

use App\Repositories\Adapter\Eloquent\KategoriAnggaranRepository;
use App\Repositories\Adapter\Eloquent\LogKategoriAnggaranRepository;
use App\Repositories\Adapter\Query\KategoriAnggaranQueryRepository;
use App\Repositories\Adapter\SubKategoriAnggaranRepository;
use App\Repositories\Interfaces\KategoriAnggaranQueryRepositoryInterface;
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

        $this->app->bind(
            KategoriAnggaranQueryRepositoryInterface::class,
            KategoriAnggaranQueryRepository::class
        );

        $this->app->bind(
            LogKategoriAnggaranRepository::class
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
