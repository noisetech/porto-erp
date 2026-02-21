<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KategoriAnggaran extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kategori_anggaran';

    protected $fillable = [
        'kategori_anggaran',
        'slug'
    ];
}
