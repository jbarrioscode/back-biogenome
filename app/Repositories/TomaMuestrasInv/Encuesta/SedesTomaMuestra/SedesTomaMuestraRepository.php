<?php

namespace App\Repositories\TomaMuestrasInv\Encuesta\SedesTomaMuestra;

use App\Models\TomaMuestrasInv\Muestras\SedesTomaMuestra;
use App\Traits\AuthenticationTrait;
use Illuminate\Http\Request;

class SedesTomaMuestraRepository implements SedesTomaMuestraRepositoryInterface
{
    use AuthenticationTrait;
public function getSedesTomaMuestra(Request $request)
{
    try {

       $sedes=SedesTomaMuestra::all();

        if (count($sedes)==0) return $this->error("No se encontró sedes", 204, []);

        return $this->success($sedes,count($sedes),'ok',200);

    }catch (\Throwable $th) {
        throw $th;
    }

}
}
