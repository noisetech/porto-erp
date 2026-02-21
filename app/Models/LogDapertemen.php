<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogDapertemen extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'log_dapertemen';

    protected $fillable = [
        'user_id',
        'dapertemen_id',
        'keterangan'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function dapertemen()
    {
        return $this->belongsTo(Dapertemen::class, 'dapertemen_id', 'id');
    }
}
