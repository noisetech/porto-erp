<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jabatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'jabatan';

    protected $fillable = [
        'dapertemen_id',
        'jabatan',
        'slug'
    ];

    public function dapertemen()
    {
        return $this->belongsTo(Dapertemen::class, 'dapertemen_id');
    }

    public function log_jabatan()
    {
        return $this->hasMany(LogJabatan::class, 'jabatan_id', 'id');
    }
}
