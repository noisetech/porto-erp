<?php

namespace App\Applications\KategoriAnggaran\UseCases;

use App\Applications\KategoriAnggaran\DTO\KategoriAnggaranDTO;
use App\Applications\KategoriAnggaran\DTO\LogKategoriAnggaranDTO;
use App\Domain\KategoriAnggaran\Repositories\Interfaces\KategoriAnggaranRepositoryInterface;
use App\Infrastructure\Persistence\Eloquent\LogKategoriAnggaranRepository;
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
