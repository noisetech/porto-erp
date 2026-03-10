<?php

namespace App\Infrastructure\Persistence\Eloquent;

use App\Applications\KategoriAnggaran\DTO\KategoriAnggaranDTO;
use App\Domain\KategoriAnggaran\Entities\KategoriAnggaranEntity;
use App\Domain\KategoriAnggaran\Repositories\Interfaces\KategoriAnggaranRepositoryInterface;
use App\Models\KategoriAnggaran;

class KategoriAnggaranRepository implements KategoriAnggaranRepositoryInterface
{

    public function simpan(KategoriAnggaranDTO $dto): KategoriAnggaranEntity
    {
        $model = KategoriAnggaran::create([
            'kode_kategori' => $dto->kode_kategori,
            'nama_kategori' => $dto->nama_kategori,
            'keterangan' => $dto->keterangan
        ]);

        return $this->mapToEntity($model);
    }

    public function update(KategoriAnggaranDTO $dto): KategoriAnggaranEntity
    {
        $model = KategoriAnggaran::findOrFail($dto->id);

        $model->update([
            'kode_kategori' => $dto->kode_kategori,
            'nama_kategori' => $dto->nama_kategori,
            'keterangan' => $dto->keterangan
        ]);

        return $this->mapToEntity($model);
    }

    public function getDataById(int $id): ?KategoriAnggaranEntity
    {
        $model = KategoriAnggaran::find($id);

        if (!$model) {
            return null;
        }

        return $this->mapToEntity($model);
    }

    public function hapus(int $id): bool
    {
        $model = KategoriAnggaran::findOrFail($id);

        return $model->delete();
    }

    private function mapToEntity(KategoriAnggaran $model): KategoriAnggaranEntity
    {
        return new KategoriAnggaranEntity(
            id: $model->id,
            kode_kategori: $model->kode_kategori,
            nama_kategori: $model->nama_kategori,
            keterangan: $model->keterangan
        );
    }
}
