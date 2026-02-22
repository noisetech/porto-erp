<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogCoa extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'log_coa';

    protected $fillable = [
        'coa_id',
        'user_id',
        'keterangan'
    ];

    public function coa()
    {
        return $this->belongsTo(COA::class, 'coa_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
