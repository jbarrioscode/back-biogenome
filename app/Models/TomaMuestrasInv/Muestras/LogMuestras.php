<?php

namespace App\Models\TomaMuestrasInv\Muestras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LogMuestras extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'log_muestras';

    protected $fillable = [
        'muestra_id',
        'estado_id',
        'user_id'
    ];
}
