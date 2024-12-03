<?php

namespace App\Models\TomaMuestrasInv;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AsignacionMuestraUbicacion extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'minv_asignacion_muestra_ubicacion';

    protected $fillable = [
        'caja_nevera_id',
        'user_id_located',
        'minv_formulario_muestras_id'
    ];
}
