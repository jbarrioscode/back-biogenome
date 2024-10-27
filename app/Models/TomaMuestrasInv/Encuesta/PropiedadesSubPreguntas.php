<?php

namespace App\Models\TomaMuestrasInv\Encuesta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropiedadesSubPreguntas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'propiedades_sub_preguntas';

    protected $fillable = [
        'parametro',
        'propiedad',
        'sub_pregunta_id'
    ];
}
