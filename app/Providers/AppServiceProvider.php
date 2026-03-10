<?php

namespace App\Providers;

use App\Domain\KategoriAnggaran\Repositories\KategoriAnggaranQueryRepositoryInterface;
use App\Domain\KategoriAnggaran\Repositories\KategoriAnggaranRepositoryInterface;
use App\Domain\SubKategoriAnggaran\Repositories\SubKategoriAnggaranRepositoryInterface;
use App\Infrastructure\KategoriAnggaran\Eloquent\KategoriAnggaranRepository;
use App\Infrastructure\KategoriAnggaran\QueryBuilder\KategoriAnggaranQueryRepository;
use App\Domain\KategoriAnggaran\Repositories\LogKategoriAnggaranRepositoryInterface;
use App\Domain\SubKategoriAnggaran\Repositories\LogSubKategoriAnggaranRepositoryInterface;
use App\Domain\SubKategoriAnggaran\Repositories\SubKategoriAnggaranQueryRepositoryInterface;
use App\Infrastructure\KategoriAnggaran\Eloquent\LogKategoriAnggaranRepository;
use App\Infrastructure\SubKategoriAnggaran\Eloquent\LogSubKategoriAnggaranRepository;
use App\Infrastructure\SubKategoriAnggaran\Eloquent\SubKategoriAnggaranRepository;
use App\Infrastructure\SubKategoriAnggaran\QueryBuilder\SubKategoriAnggaranQueryRepository;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        /*
    |--------------------------------------------------------------------------
    | Bagian Kategori Anggaran
    |--------------------------------------------------------------------------
    */
        $this->app->bind(
            KategoriAnggaranQueryRepositoryInterface::class,
            KategoriAnggaranQueryRepository::class
        );
        $this->app->bind(
            KategoriAnggaranRepositoryInterface::class,
            KategoriAnggaranRepository::class
        );

        $this->app->bind(
            LogKategoriAnggaranRepositoryInterface::class,
            LogKategoriAnggaranRepository::class
        );
        /*
        |--------------------------------------------------------------------------
        | Bagian Sub Kategori Anggaran
        |--------------------------------------------------------------------------
        */
        $this->app->bind(
            SubKategoriAnggaranQueryRepositoryInterface::class,
            SubKategoriAnggaranQueryRepository::class
        );

        $this->app->bind(
            SubKategoriAnggaranRepositoryInterface::class,
            SubKategoriAnggaranRepository::class
        );

        $this->app->bind(
            LogSubKategoriAnggaranRepositoryInterface::class,
            LogSubKategoriAnggaranRepository::class
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
