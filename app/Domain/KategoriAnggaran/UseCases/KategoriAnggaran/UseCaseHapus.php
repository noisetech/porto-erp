<?php


namespace App\Domain\KategoriAnggaran\UseCases\KategoriAnggaran;

use App\Domain\KategoriAnggaran\DTO\KategoriAnggaran\LogKategoriAnggaranDTO;
use App\Domain\KategoriAnggaran\Repositories\Adapter\Eloquent\LogKategoriAnggaranRepository;
use App\Domain\KategoriAnggaran\Repositories\Interfaces\KategoriAnggaranRepositoryInterface;

class UseCaseHapus
{
    private KategoriAnggaranRepositoryInterface $kategoriAnggaranRepositoryInterface;
    private LogKategoriAnggaranRepository $logKategoriAnggaranRepository;

    public function __construct(KategoriAnggaranRepositoryInterface $k, LogKategoriAnggaranRepository $l)
    {
        $this->kategoriAnggaranRepositoryInterface = $k;
        $this->logKategoriAnggaranRepository = $l;
    }

    public function execute(int $id, $userId): bool
    {
        return DB::transaction(function () use ($id, $userId) {
            return tap(
                $this->kategoriAnggaranRepositoryInterface->hapus($id),
                fn($deleted) => $this->logKategoriAnggaranRepository->simpan(
                    new LogKategoriAnggaranDTO(
                        user_id: $userId,
                        kategori_anggaran: $id,
                        keterangan: 'menghapus data'
                    )
                )
            );
        });
    }
}
