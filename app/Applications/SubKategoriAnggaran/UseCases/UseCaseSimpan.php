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
                null,
                $dto->kategori_anggaran_id,
                $dto->kode_sub_kategori,
                $dto->nama_sub_kategori,
                $dto->keterangan
            );

            $entity->setCoaIds($dto->coa_ids);

            $sub_kategori_anggaran = $this->repository->simpan($entity);

            $log = new LogSubKategoriAnggaranEntity(
                null,
                $userId,
                $sub_kategori_anggaran->id(),
                LogSubKategoriAnggaranEntity::ACTION_CREATE
            );

            $this->logRepository->simpan($log);

            return $sub_kategori_anggaran;
        });
    }
}
