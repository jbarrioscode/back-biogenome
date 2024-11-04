<?php

namespace App\Models\TomaMuestrasInv\Paciente;

use App\Models\TomaMuestrasInv\Muestras\FormularioMuestra;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class ConsentimientoInformadoPaciente extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'consentimiento_informado_pacientes';

    protected $fillable = [
        'tipo_consentimiento_informado_id',
        'paciente_id',
        'firma',
        'nombre_completo',
        'tipo_documento',
        'documento',
        'relacion_sujeto',
        'direccion',
        'firmante_id',
    ];

}
