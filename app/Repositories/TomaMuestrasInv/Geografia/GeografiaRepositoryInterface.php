<?php

namespace App\Repositories\TomaMuestrasInv\Geografia;

use Illuminate\Http\Request;

interface GeografiaRepositoryInterface
{
public function getSedesTomaMuestra(Request $request);

    public function getPais(Request $request);

    public function getDepartamento(Request $request, $pais_id);

    public function getCiudad(Request $request, $departamento_id);

    public function getCiudadesForPaisId(Request $request, $pais_id);


}
