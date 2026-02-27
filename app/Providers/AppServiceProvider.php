<?php

namespace App\Providers;

use App\Domain\KategoriAnggaran\Repositories\Adapter\Eloquent\KategoriAnggaranRepository;
use App\Domain\KategoriAnggaran\Repositories\Adapter\Eloquent\LogKategoriAnggaranRepository;
use App\Domain\KategoriAnggaran\Repositories\Adapter\Query\KategoriAnggaranQueryRepository;
use App\Domain\KategoriAnggaran\Repositories\Interfaces\KategoriAnggaranQueryRepositoryInterface;
use App\Domain\KategoriAnggaran\Repositories\Interfaces\KategoriAnggaranRepositoryInterface;
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
            KategoriAnggaranQueryRepositoryInterface::class,
            KategoriAnggaranQueryRepository::class
        );


        $this->app->bind(
            KategoriAnggaranRepositoryInterface::class,
            KategoriAnggaranRepository::class

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
