<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dapertemen extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'dapertemen';

    protected $fillable = [
        'kode',
        'nama_dapertemen',
        'slug'
    ];

    public function jabatan()
    {
        return $this->hasMany(Jabatan::class, 'dapertemen_id');
    }


    public function log_dapertemen()
    {
        return $this->hasMany(LogDapertemen::class, 'dapertemen_id', 'id');
    }
}
