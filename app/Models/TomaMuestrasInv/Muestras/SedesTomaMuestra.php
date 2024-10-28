<?php

namespace App\Models\TomaMuestrasInv\Muestras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SedesTomaMuestra extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'sedes_toma_muestras';

    protected $fillable = [
        'nombre',
        'descripcion',
        'ciudad_id'
    ];
}
