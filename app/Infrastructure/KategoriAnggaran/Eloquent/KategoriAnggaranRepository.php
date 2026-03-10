<?php

namespace App\Infrastructure\KategoriAnggaran\Eloquent;

use App\Domain\KategoriAnggaran\Entities\KategoriAnggaranEntity;
use App\Domain\KategoriAnggaran\Repositories\KategoriAnggaranRepositoryInterface;
use App\Models\KategoriAnggaran;

class KategoriAnggaranRepository implements KategoriAnggaranRepositoryInterface
{

    private function mapToEntity(KategoriAnggaran $model): KategoriAnggaranEntity
    {
        return new KategoriAnggaranEntity(
            id: $model->id,
            kode_kategori: $model->kode_kategori,
            nama_kategori: $model->nama_kategori,
            keterangan: $model->keterangan
        );
    }


    public function simpan(KategoriAnggaranEntity $entity): KategoriAnggaranEntity
    {
        $model = KategoriAnggaran::create([
            'kode_kategori' => $entity->kode_kategori,
            'nama_kategori' => $entity->nama_kategori,
            'keterangan'   => $entity->keterangan
        ]);

        return $this->mapToEntity($model);
    }

    public function update(KategoriAnggaranEntity $entity): KategoriAnggaranEntity
    {
        $model = KategoriAnggaran::findOrFail($entity->id);

        $model->update([
            'kode_kategori' => $entity->kode_kategori,
            'nama_kategori' => $entity->nama_kategori,
            'keterangan'    => $entity->keterangan
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

        return (bool) $model->delete();
    }
}
