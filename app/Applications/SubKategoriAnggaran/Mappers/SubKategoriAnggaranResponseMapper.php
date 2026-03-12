<?php

namespace App\Applications\SubKategoriAnggaran\Mappers;

use App\Domain\SubKategoriAnggaran\Entities\SubKategoriAnggaranEntity;

class SubKategoriAnggaranResponseMapper
{
    public static function map(SubKategoriAnggaranEntity $entity): array
    {
        return [
            'id' => $entity->id(),
            'kategori_anggaran_id' => $entity->kategoriAnggaranId(),
            'kode_sub_kategori' => $entity->kode(),
            'nama_sub_kategori' => $entity->nama(),
            'keterangan' => $entity->keterangan(),
            'coa' => $entity->coa(),
            'kategori_anggaran' => $entity->kategoriAnggaran(),
        ];
    }
}
