<?php

namespace App\Models\TomaMuestrasInv\Encuesta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OpcionesRespuestas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'opciones_respuestas';

    protected $fillable = [
        'opcion',
        'pregunta_id'
    ];
}
