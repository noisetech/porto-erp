<?php

namespace App\Providers;

use App\Domain\KategoriAnggaran\Repositories\KategoriAnggaranQueryRepositoryInterface;
use App\Domain\KategoriAnggaran\Repositories\KategoriAnggaranRepositoryInterface;
use App\Infrastructure\KategoriAnggaran\Eloquent\KategoriAnggaranRepository;
use App\Infrastructure\KategoriAnggaran\QueryBuilder\KategoriAnggaranQueryRepository;
use App\Domain\KategoriAnggaran\Repositories\LogKategoriAnggaranRepositoryInterface;
use App\Infrastructure\KategoriAnggaran\Eloquent\LogKategoriAnggaranRepository;

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
            LogKategoriAnggaranRepositoryInterface::class,
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
