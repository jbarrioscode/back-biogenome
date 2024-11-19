<?php

namespace App\Repositories\TomaMuestrasInv\Muestra;

use App\Http\Requests\TomaMuestrasInv\Muestra\MuestraRequest;
use Illuminate\Http\Request;

interface MuestraRepositoryInterface
{
    public function obtenerTipoEstudio(Request $request);
    public function guardarMuestra(MuestraRequest $request);
    public function getPacientePendienteInfoClinica(Request $request);
    public function guardarInfoClinica(Request $request);
    public function guardarYcerrarInfoClinica(Request $request);
    public function getRetornarInfoClinica(Request $request,$muestra_id);


}
