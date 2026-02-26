<?php

namespace App\UseCases\KategoriAnggaran;

use App\DTO\KategoriAnggaran\KategoriAnggaranDTO;
use App\DTO\KategoriAnggaran\LogKategoriAnggaranDTO;
use App\Repositories\Interfaces\KategoriAnggaranRepositoryInterface;
use App\Repositories\Query\QueryLogKategoriAnggaranRepository;
use Illuminate\Support\Facades\DB;

class UseCaseUpdate
{
    protected KategoriAnggaranRepositoryInterface $kategoriAnggaranRepositoryInterface;
    protected QueryLogKategoriAnggaranRepository $logKategoriAnggaranRepository;

    public function __construct(KategoriAnggaranRepositoryInterface $k, QueryLogKategoriAnggaranRepository $l)
    {
        $this->kategoriAnggaranRepositoryInterface = $k;
        $this->logKategoriAnggaranRepository = $l;
    }

    public function execute(KategoriAnggaranDTO $dto, int $userId)
    {
        return DB::transaction(function () use ($dto, $userId) {
            $kategori = $this->kategoriAnggaranRepositoryInterface->update($dto);

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
