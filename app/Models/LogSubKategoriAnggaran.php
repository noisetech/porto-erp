<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogSubKategoriAnggaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'l_sub_kategori_anggaran';

    protected $fillable = [
        'user_id',
        'sub_kategori_anggaran_id',
        'keterangan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function sub_kategori_anggaran()
    {
        return $this->belongsTo(SubKategoriAnggaran::class, 'sub_kategori_anggaran_id', 'id');
    }
}
