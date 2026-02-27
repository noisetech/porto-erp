<?php

namespace App\Domain\KategoriAnggaran\UseCases\KategoriAnggaran;

use App\Domain\KategoriAnggaran\DTO\KategoriAnggaran\KategoriAnggaranDTO;
use App\Domain\KategoriAnggaran\DTO\KategoriAnggaran\LogKategoriAnggaranDTO;
use App\Domain\KategoriAnggaran\Repositories\Adapter\Eloquent\LogKategoriAnggaranRepository;
use App\Domain\KategoriAnggaran\Repositories\Interfaces\KategoriAnggaranRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UseCaseSimpan
{
    private KategoriAnggaranRepositoryInterface $kategoriAnggaranRepositoryInterface;
    private LogKategoriAnggaranRepository $logKategoriAnggaranRepository;

    public function __construct(KategoriAnggaranRepositoryInterface $k, LogKategoriAnggaranRepository $l)
    {
        $this->kategoriAnggaranRepositoryInterface = $k;
        $this->logKategoriAnggaranRepository = $l;
    }

    public function execute(KategoriAnggaranDTO $dto, int $userId)
    {
        return DB::transaction(function () use ($dto, $userId) {
            $kategori = $this->kategoriAnggaranRepositoryInterface->simpan($dto);

            $this->logKategoriAnggaranRepository->simpan(
                new LogKategoriAnggaranDTO(
                    user_id: $userId,
                    kategori_anggaran: $kategori->id,
                    keterangan: 'menambahkan data'
                )
            );

            return $kategori;
        });
    }
}
