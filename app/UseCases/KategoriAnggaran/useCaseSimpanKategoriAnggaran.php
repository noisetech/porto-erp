<?php

namespace App\UseCases\KategoriAnggaran;

use App\DTO\KategoriAnggaran\KategoriAnggaranDTO;
use App\DTO\KategoriAnggaran\LogKategoriAnggaranDTO;
use App\Repositories\Interfaces\KategoriAnggaranRepositoryInterface;
use App\Repositories\LogKategoriAnggaranRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UseCaseSimpanKategoriAnggaran
{
    protected KategoriAnggaranRepositoryInterface $kategoriAnggaranRepositoryInterface;
    protected LogKategoriAnggaranRepository $logKategoriAnggaranRepository;

    public function __construct(KategoriAnggaranRepositoryInterface $k, LogKategoriAnggaranRepository $l)
    {
        $this->kategoriAnggaranRepositoryInterface = $k;
        $this->logKategoriAnggaranRepository = $l;
    }

    public function excute(KategoriAnggaranDTO $dto)
    {
        return DB::transaction(function () use ($dto) {
            $kategori_anggaran = $this->kategoriAnggaranRepositoryInterface->simpan($dto);

            $this->logKategoriAnggaranRepository->simpan(
                new LogKategoriAnggaranDTO(
                    user_id: Auth::id(),
                    kategori_anggaran: $kategori_anggaran->id,
                    keterangan: 'menambahkan data'
                )
            );
            return $kategori_anggaran;
        });
    }
}
