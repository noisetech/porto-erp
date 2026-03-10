<?php

namespace App\Applications\KategoriAnggaran\UseCases;

use App\Domain\KategoriAnggaran\Entities\LogKategoriAnggaranEntity;
use App\Domain\KategoriAnggaran\Repositories\KategoriAnggaranRepositoryInterface;
use App\Infrastructure\KategoriAnggaran\Eloquent\LogKategoriAnggaranRepository;
use Illuminate\Support\Facades\DB;

class UseCaseHapus
{
    private KategoriAnggaranRepositoryInterface $kategoriAnggaranRepositoryInterface;
    private LogKategoriAnggaranRepository $logKategoriAnggaranRepository;

    public function __construct(KategoriAnggaranRepositoryInterface $k, LogKategoriAnggaranRepository $l)
    {
        $this->kategoriAnggaranRepositoryInterface = $k;
        $this->logKategoriAnggaranRepository = $l;
    }

    public function execute(int $id, int $userId): bool
    {
        return DB::transaction(function () use ($id, $userId) {

            $deleted = $this->kategoriAnggaranRepositoryInterface->hapus($id);

            $log = new LogKategoriAnggaranEntity(
                id: null,
                user_id: $userId,
                kategori_anggaran_id: $id,
                keterangan: 'Menghapus kategori anggaran'
            );

            $this->logKategoriAnggaranRepository->simpan($log);

            return $deleted;
        });
    }
}
