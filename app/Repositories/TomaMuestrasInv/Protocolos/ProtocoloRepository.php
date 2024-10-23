<?php

namespace App\Repositories\TomaMuestrasInv\Protocolos;

use App\Models\TomaMuestrasInv\Muestras\Protocolo;
use Illuminate\Http\Request;

class ProtocoloRepository implements ProtocoloRepositoryInterface
{

   public function obtenerProtocolosActivos(Request $request)
   {
       try {

           $protocolo=Protocolo::all();

           if (count($protocolo)==0) return $this->error("No se encontró ningun protocolo", 204, []);

           return $this->success($protocolo,count($protocolo),'ok',200);

       }catch (\Throwable $th) {
           throw $th;
       }
   }

}
