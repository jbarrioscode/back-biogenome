<?php

namespace App\Models\TomaMuestrasInv\Encuesta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Preguntas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'preguntas';

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo_de_preguntas_id',
        'grupo_pregunta_id',
        'orden_pregunta'
    ];
}
