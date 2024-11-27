<?php

namespace App\Models\TomaMuestrasInv\Muestras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadosMuestras extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'minv_estados_muestras';

    protected $fillable = [
        'nombre',
        'descripcion'
    ];
}
