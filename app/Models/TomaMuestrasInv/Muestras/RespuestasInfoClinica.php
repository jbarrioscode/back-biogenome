<?php

namespace App\Models\TomaMuestrasInv\Muestras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RespuestasInfoClinica extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'respuestas_info_clinicas';

    protected $fillable = [
        'fecha',
        'respuesta',
        'unidad',
        'tipo_imagen',
        'observacion',
        'muestra_id',
        'pregunta_id',
        'valor'
    ];
}
