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
        'protocolo_id',
        'paciente_id',
        'firma'
    ];

}
