<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogKategoriAsetKantor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'log_kategori_aset_kantor';

    protected $fillable = [
        'kategori_aset_kantor_id',
        'user_id',
        'keterangan',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');

    }

    public function kategoriAsetKantor(){
        return $this->belongsTo(KategoriAsetKantor::class, 'kategori_aset_kantor_id', 'id');
    }
}
