<?php

namespace App\Applications\SubKategoriAnggaran\UseCases;

use App\Applications\SubKategoriAnggaran\DTO\SubKategoriAnggaranDTO;
use App\Domain\SubKategoriAnggaran\Entities\LogSubKategoriAnggaranEntity;
use App\Domain\SubKategoriAnggaran\Entities\SubKategoriAnggaranEntity;
use App\Domain\SubKategoriAnggaran\Repositories\LogSubKategoriAnggaranRepositoryInterface;
use App\Domain\SubKategoriAnggaran\Repositories\SubKategoriAnggaranRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UseCaseSimpan
{

    public function __construct(
        private SubKategoriAnggaranRepositoryInterface $repository,
        private LogSubKategoriAnggaranRepositoryInterface $logRepository
    ) {}

    public function execute(SubKategoriAnggaranDTO $dto, int $userId): SubKategoriAnggaranEntity
    {
        return DB::transaction(function () use ($dto, $userId) {

            $entity = new SubKategoriAnggaranEntity(
                id: null,
                kategori_anggaran_id: $dto->kategori_anggaran_id,
                kode_sub_kategori: $dto->kode_sub_kategori,
                nama_sub_kategori: $dto->nama_sub_kategori,
                keterangan: $dto->keterangan,
                coa_ids: $dto->coa_ids
            );

            $sub_kategori_anggaran = $this->repository->simpan($entity);

            $log = new LogSubKategoriAnggaranEntity(
                id: null,
                user_id: $userId,
                sub_kategori_anggaran_id: $sub_kategori_anggaran->id,
                keterangan: 'Menambahkan kategori anggaran'
            );

           $this->logRepository->simpan($log);

            return $sub_kategori_anggaran;
        });
    }
}
