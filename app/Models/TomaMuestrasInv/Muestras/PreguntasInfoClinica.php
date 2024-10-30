<?php

namespace App\Models\TomaMuestrasInv\Muestras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PreguntasInfoClinica extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'preguntas_info_clinicas';

    protected $fillable = [
        'pregunta',
        'descripcion'
    ];
}
