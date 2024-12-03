<?php

namespace App\Models\TomaMuestrasInv;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UbicacionCaja extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'ubicacion_cajas';

    protected $fillable = [
        'nombre',
        'descripcion',
        'nevera_estante_id',
        'num_caja',
        'num_fila'
    ];
}
