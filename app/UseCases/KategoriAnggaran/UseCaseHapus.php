<?php


namespace App\UseCases\KategoriAnggaran;

use App\DTO\KategoriAnggaran\LogKategoriAnggaranDTO;
use App\Repositories\Interfaces\KategoriAnggaranRepositoryInterface;
use App\Repositories\Query\QueryLogKategoriAnggaranRepository;
use Illuminate\Support\Facades\DB;

class UseCaseHapus
{
    protected KategoriAnggaranRepositoryInterface $kategoriAnggaranRepositoryInterface;
    protected QueryLogKategoriAnggaranRepository $logKategoriAnggaranRepository;

    public function __construct(KategoriAnggaranRepositoryInterface $k, QueryLogKategoriAnggaranRepository $l)
    {
        $this->kategoriAnggaranRepositoryInterface = $k;
        $this->logKategoriAnggaranRepository = $l;
    }

    public function execute(int $id, $userId): bool
    {
        return DB::transaction(function () use ($id, $userId) {
            $this->logKategoriAnggaranRepository->simpan(
                new LogKategoriAnggaranDTO(
                    user_id: $userId,
                    kategori_anggaran: $id,
                    keterangan: 'menghapus data'
                )
            );
            $this->kategoriAnggaranRepositoryInterface->hapus($id);
        });
    }
}
