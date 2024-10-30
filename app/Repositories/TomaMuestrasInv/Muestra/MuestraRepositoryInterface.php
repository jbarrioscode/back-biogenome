<?php

namespace App\Repositories\TomaMuestrasInv\Muestra;

use Illuminate\Http\Request;

interface MuestraRepositoryInterface
{
    public function obtenerTipoEstudio(Request $request);
    public function guardarMuestra(Request $request);
    public function guardarInfoClinica(Request $request);




}
