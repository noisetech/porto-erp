<?php

namespace App\Applications\KategoriAnggaran\UseCases;

use App\Applications\KategoriAnggaran\DTO\KategoriAnggaranDTO;
use App\Applications\KategoriAnggaran\DTO\LogKategoriAnggaranDTO;
use App\Domain\KategoriAnggaran\Entities\KategoriAnggaranEntity;
use App\Domain\KategoriAnggaran\Repositories\KategoriAnggaranRepositoryInterface;
use App\Infrastructure\KategoriAnggaran\Eloquent\LogKategoriAnggaranRepository;
use Illuminate\Support\Facades\DB;

class UseCaseUpdate
{
    private KategoriAnggaranRepositoryInterface $kategoriRepository;
    private LogKategoriAnggaranRepository $logRepository;

    public function __construct(
        KategoriAnggaranRepositoryInterface $kategoriRepository,
        LogKategoriAnggaranRepository $logRepository
    ) {
        $this->kategoriRepository = $kategoriRepository;
        $this->logRepository = $logRepository;
    }

    public function execute(KategoriAnggaranDTO $dto, int $userId)
    {
        return DB::transaction(function () use ($dto, $userId) {

            // DTO → Entity
            $entity = new KategoriAnggaranEntity(
                id: $dto->id,
                kode_kategori: $dto->kode_kategori,
                nama_kategori: $dto->nama_kategori,
                keterangan: $dto->keterangan
            );

            $kategori = $this->kategoriRepository->update($entity);

            $this->logRepository->simpan(
                new LogKategoriAnggaranDTO(
                    user_id: $userId,
                    kategori_anggaran: $kategori->id,
                    keterangan: 'Mengubah kategori anggaran'
                )
            );

            return $kategori;
        });
    }
}
