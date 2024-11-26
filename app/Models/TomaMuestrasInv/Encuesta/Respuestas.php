<?php

namespace App\Models\TomaMuestrasInv\Encuesta;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Respuestas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'respuestas';

    protected $fillable = [
        'respuesta',
        'pregunta_id',
        'muestras_id'
    ];
}
