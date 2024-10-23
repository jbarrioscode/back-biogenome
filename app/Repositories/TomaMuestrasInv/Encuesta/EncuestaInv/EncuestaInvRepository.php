<?php

namespace App\Repositories\TomaMuestrasInv\Encuesta\EncuestaInv;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EncuestaInvRepository implements EncuestaInvRepositoryInterface
{
    public function crearEncuesta(Request $request)
    {

        try {
            DB::beginTransaction();

            //SE CREA EL FORMULARIO Y LUEGO SE GUARDA LOS DETALLES




            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

}
