<?php

namespace App\Infrastructure\SubKategoriAnggaran\Eloquent;
use App\Domain\SubKategoriAnggaran\Entities\SubKategoriAnggaranEntity;
use App\Domain\SubKategoriAnggaran\Repositories\SubKategoriAnggaranRepositoryInterface;
use App\Models\SubKategoriAnggaran;

class SubKategoriAnggaranRepository implements SubKategoriAnggaranRepositoryInterface
{

    private function mapToEntity(SubKategoriAnggaran $model): SubKategoriAnggaranEntity
    {
        return new SubKategoriAnggaranEntity(
            id: $model->id,
            kode_kategori: $model->kode_kategori,
            nama_kategori: $model->nama_kategori,
            keterangan: $model->keterangan
        );
    }


    public function simpan(SubKategoriAnggaranEntity $entity): SubKategoriAnggaranEntity
    {
        $model = SubKategoriAnggaran::create([
            'kode_kategori' => $entity->kode_kategori,
            'nama_kategori' => $entity->nama_kategori,
            'keterangan'   => $entity->keterangan
        ]);

        return $this->mapToEntity($model);
    }

    public function update(SubKategoriAnggaranEntity $entity): SubKategoriAnggaranEntity
    {
        $model = SubKategoriAnggaran::findOrFail($entity->id);

        $model->update([
            'kode_kategori' => $entity->kode_kategori,
            'nama_kategori' => $entity->nama_kategori,
            'keterangan'    => $entity->keterangan
        ]);

        return $this->mapToEntity($model);
    }

    public function getDataById(int $id): ?SubKategoriAnggaranEntity
    {
        $model = SubKategoriAnggaran::find($id);

        if (!$model) {
            return null;
        }

        return $this->mapToEntity($model);
    }

    public function hapus(int $id): bool
    {
        $model = SubKategoriAnggaran::findOrFail($id);

        return (bool) $model->delete();
    }
}
