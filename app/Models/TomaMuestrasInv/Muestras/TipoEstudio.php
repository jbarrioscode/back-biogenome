<?php

namespace App\Models\TomaMuestrasInv\Muestras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoEstudio extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'minv_tipo_estudios';

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

}
