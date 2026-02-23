<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubKategoriAnggaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sub_kategori_anggran';

    protected $fillable = [
        'kategori_anggaran_id',
        'kode_sub_kategori',
        'nama_sub_kategori',
        'keterangan'
    ];

    public function kategoriAnggaran()
    {
        return $this->belongsTo(
            KategoriAnggaran::class,
            'kategori_anggaran_id',
            'id'
        );
    }

    public function coa()
    {
        return $this->belongsToMany(
            COA::class,
            'mapping_sub_kategori_coa',
            'sub_kategori_anggaran_id',
            'coa_id'
        );
    }
}
