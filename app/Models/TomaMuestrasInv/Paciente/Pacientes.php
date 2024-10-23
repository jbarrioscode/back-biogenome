<?php

namespace App\Models\TomaMuestrasInv\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pacientes extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'pacientes';

    protected $fillable = [
        'tipo_doc',
        'numero_documento',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'fecha_nacimiento',
        'fecha_expedicion',
        'pais_residencia',
        'departamento_residencia',
        'ciudad_residencia',
        'telefono_celular'
    ];

}
