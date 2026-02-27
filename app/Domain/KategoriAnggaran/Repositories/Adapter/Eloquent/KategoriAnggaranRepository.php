<?php

namespace App\Domain\KategoriAnggaran\Repositories\Adapter\Eloquent;

use App\Domain\KategoriAnggaran\DTO\KategoriAnggaran\KategoriAnggaranDTO;
use App\Domain\KategoriAnggaran\Repositories\Interfaces\KategoriAnggaranRepositoryInterface;
use App\Models\KategoriAnggaran;

class KategoriAnggaranRepository implements KategoriAnggaranRepositoryInterface
{

    public function simpan(KategoriAnggaranDTO $dto): KategoriAnggaran
    {
        return KategoriAnggaran::create([
            'kode_kategori' => $dto->kode_kategori,
            'nama_kategori' => $dto->nama_kategori,
            'keterangan' => $dto->keterangan
        ]);
    }

    public function update(KategoriAnggaranDTO $dto): KategoriAnggaran
    {
        $kategori = KategoriAnggaran::find($dto->id);

        $kategori->update([
            'kode_kategori' => $dto->kode_kategori,
            'nama_kategori' => $dto->nama_kategori,
            'keterangan' => $dto->kode_kategori,
        ]);

        return $kategori;
    }

    public function hapus(int $id): bool
    {
        $kategori_anggarran =  KategoriAnggaran::find($id);

        $kategori_anggarran->delete();

        return true;
    }


    public function getDataById(int $id): ?KategoriAnggaran
    {
        return  KategoriAnggaran::find($id);
    }
}
