<?php

namespace App\Models\TomaMuestrasInv\Paciente;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Firmante extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'firmante';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];
}
