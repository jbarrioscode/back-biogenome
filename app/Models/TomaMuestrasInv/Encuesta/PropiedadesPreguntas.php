<?php

namespace App\Models\TomaMuestrasInv\Encuesta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropiedadesPreguntas extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'propiedades_preguntas';

    protected $fillable = [
        'parametro',
        'propiedad',
        'pregunta_id'
    ];
}
