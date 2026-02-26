<?php

namespace App\Providers;

use App\Repositories\Interfaces\KategoriAnggaranRepositoryInterface;
use App\Repositories\Interfaces\SubKategoriAnggaranRepositoryInterface;
use App\Repositories\Query\QueryKategoriAnggaranRepository;
use App\Repositories\Query\QueryLogKategoriAnggaranRepository;
use App\Repositories\Query\QuerySubKategoriAnggaranRepository;
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
            QuerySubKategoriAnggaranRepository::class
        );

        $this->app->bind(
            KategoriAnggaranRepositoryInterface::class,
            QueryKategoriAnggaranRepository::class
        );

        $this->app->bind(
            QueryLogKategoriAnggaranRepository::class
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
