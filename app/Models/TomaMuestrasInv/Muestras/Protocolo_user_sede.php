<?php

namespace App\Models\TomaMuestrasInv\Muestras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Protocolo_user_sede extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'protocolo_user_sedes';

    protected $fillable = [
        'user_id',
        'protocolo_id',
        'sede_id'
    ];
}
