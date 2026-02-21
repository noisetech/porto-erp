<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogKategoriAnggaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'log_kategori_anggaran';

    protected $fillable = [
        'kategori_anggaran_id',
        'user_id',
        'keterangan'
    ];

    public function kategori_anggaran()
    {
        return $this->belongsTo(KategoriAnggaran::class, 'kategori_anggaran_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
