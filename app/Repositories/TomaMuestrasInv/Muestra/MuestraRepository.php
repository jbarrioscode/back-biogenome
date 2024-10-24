<?php

namespace App\Repositories\TomaMuestrasInv\Muestra;

use App\Models\TomaMuestrasInv\Muestras\TipoEstudio;
use App\Traits\RequestResponseFormatTrait;
use Illuminate\Http\Request;

class MuestraRepository implements MuestraRepositoryInterface
{
    use RequestResponseFormatTrait;
    public function obtenerTipoEstudio(Request $request)
    {
        try {

            $tipoMuestras = TipoEstudio::all();

            if (count($tipoMuestras) == 0) return $this->error("No se encontró ningun tipo de Estudio", 204, []);

            return $this->success($tipoMuestras, count($tipoMuestras), 'ok', 200);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
