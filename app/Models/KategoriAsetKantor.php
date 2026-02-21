<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriAsetKantor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kategori_aset_kantor';

    protected $fillable = [
        'kode',
        'kategori_aset',
        'slug',
    ];

    public function asetKantor()
    {
        return $this->hasMany(AsetKantor::class, 'kategori_aset_kantor_id', 'id');
    }
}
