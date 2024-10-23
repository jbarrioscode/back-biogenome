<?php

namespace App\Repositories\TomaMuestrasInv\Encuesta\EncuestaInv;

use Illuminate\Http\Request;

interface EncuestaInvRepositoryInterface
{
public function crearEncuesta(Request $request);

}
