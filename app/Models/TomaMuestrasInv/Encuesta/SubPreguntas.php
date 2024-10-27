<?php

namespace App\Models\TomaMuestrasInv\Encuesta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubPreguntas extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'sub_preguntas';

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo_de_preguntas_id',
        'pregunta_id',
        'condicion_seleccion'
    ];
}
