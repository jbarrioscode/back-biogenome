<?php

namespace App\Repositories\TomaMuestrasInv\EncuestaInv;

use Illuminate\Http\Request;

interface EncuestaInvRepositoryInterface
{
public function renderizarEncuesta(Request $request,$protocolo_id);

}
