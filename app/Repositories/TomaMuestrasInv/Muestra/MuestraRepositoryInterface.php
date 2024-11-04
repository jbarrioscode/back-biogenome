<?php

namespace App\Repositories\TomaMuestrasInv\Muestra;

use App\Http\Requests\TomaMuestrasInv\Muestra\MuestraRequest;
use Illuminate\Http\Request;

interface MuestraRepositoryInterface
{
    public function obtenerTipoEstudio(Request $request);
    public function guardarMuestra(MuestraRequest $request);
    public function guardarInfoClinica(Request $request);




}
