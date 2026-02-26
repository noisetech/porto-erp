<?php


namespace App\UseCases\KategoriAnggaran;

use App\DTO\KategoriAnggaran\LogKategoriAnggaranDTO;
use App\Repositories\Adapter\Eloquent\LogKategoriAnggaranRepository;
use App\Repositories\Interfaces\KategoriAnggaranRepositoryInterface;
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
