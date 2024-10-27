<?php

namespace App\Models\TomaMuestrasInv\Encuesta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GrupoPregunta extends Model
{
    use HasFactory;
    protected $table = 'grupo_preguntas';

    protected $fillable = [
        'nombre',
        'descripcion',
        'orden_grupo',
        'protocolo_id'
    ];

}
