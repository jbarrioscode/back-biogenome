<?php

namespace App\Repositories\TomaMuestrasInv\EncuestaInv;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EncuestaInvRepository implements EncuestaInvRepositoryInterface
{
    public function renderizarEncuesta(Request $request,$protocolo_id)
    {

        try {
            //DB::beginTransaction();

            return $protocolo_id;

            //DB::commit();
        } catch (\Throwable $th) {
            //DB::rollBack();
            throw $th;
        }
    }

}
