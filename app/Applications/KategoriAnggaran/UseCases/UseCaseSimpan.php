<?php

namespace App\Applications\KategoriAnggaran\UseCases;

use App\Applications\KategoriAnggaran\DTO\KategoriAnggaranDTO;
use App\Applications\KategoriAnggaran\DTO\LogKategoriAnggaranDTO;
use App\Domain\KategoriAnggaran\Entities\KategoriAnggaranEntity;
use App\Domain\KategoriAnggaran\Repositories\KategoriAnggaranRepositoryInterface;
use App\Domain\KategoriAnggaran\Repositories\LogKategoriAnggaranRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UseCaseSimpan
{
    public function __construct(
        private KategoriAnggaranRepositoryInterface $repository,
        private LogKategoriAnggaranRepositoryInterface $logRepository
    ) {}

    public function execute(KategoriAnggaranDTO $dto, int $userId): KategoriAnggaranEntity
    {
        return DB::transaction(function () use ($dto, $userId) {
            $entity = new KategoriAnggaranEntity(
                id: null,
                kode_kategori: $dto->kode_kategori,
                nama_kategori: $dto->nama_kategori,
                keterangan: $dto->keterangan
            );

            $kategori = $this->repository->simpan($entity);

            $this->logRepository->simpan(
                new LogKategoriAnggaranDTO(
                    user_id: $userId,
                    kategori_anggaran: $kategori->id,
                    keterangan: 'Menambahkan kategori anggaran'
                )
            );

            return $kategori;
        });
    }
}
