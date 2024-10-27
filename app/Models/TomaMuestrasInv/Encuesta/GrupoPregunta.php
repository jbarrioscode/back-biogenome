<?php

namespace App\Models\TomaMuestrasInv\Encuesta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GrupoPregunta extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'grupo_preguntas';

    protected $fillable = [
        'nombre',
        'descripcion',
        'orden_grupo',
        'protocolo_id'
    ];

}
