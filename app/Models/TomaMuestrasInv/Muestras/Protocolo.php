<?php

namespace App\Models\TomaMuestrasInv\Muestras;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Protocolo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'protocolos';

    protected $fillable = [
        'nombre',
        'descripcion'
    ];
}
