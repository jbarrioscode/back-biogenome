<?php

namespace App\Repositories\TomaMuestrasInv\Protocolos;

use App\Models\TomaMuestrasInv\Muestras\Protocolo;
use App\Models\TomaMuestrasInv\Muestras\Protocolo_user_sede;
use App\Traits\RequestResponseFormatTrait;
use Illuminate\Http\Request;

class ProtocoloRepository implements ProtocoloRepositoryInterface
{
    use RequestResponseFormatTrait;
   public function obtenerTodosProtocolos(Request $request)
   {
       try {

           $protocolo=Protocolo::all();

           if (count($protocolo)==0) return $this->error("No se encontró ningun protocolo", 204, []);

           return $this->success($protocolo,count($protocolo),'ok',200);

       }catch (\Throwable $th) {
           throw $th;
       }
   }

    public function obtenerProtocosActivosPorUserSede(Request $request,$sede_id)
    {
        try {

            $protocolo=Protocolo_user_sede::select('stm.id as id_sede', 'stm.descripcion as sede', 'p2.id as protocolo_id', 'p2.nombre as protocolo')
                ->leftJoin('sedes_toma_muestras as stm', 'stm.id', '=', 'protocolo_user_sedes.sede_id')
                ->leftJoin('protocolos as p2', 'p2.id', '=', 'protocolo_user_sedes.protocolo_id')
                ->where('protocolo_user_sedes.user_id', 1/*\auth()->user()->id*/)
                 ->where('stm.id', $sede_id)
                ->get();

            $data = $protocolo->groupBy('id_sede')->map(function ($items) {
                return [
                    'sede' => $items->first()->sede,
                    'sede_id' => $items->first()->id_sede,
                    'protocolos' => $items->map(function ($item) {
                        return [
                            'protocolo_id' => $item->protocolo_id,
                            'protocolo' => $item->protocolo,
                        ];
                    })->toArray()
                ];
            })->values()->first();

            if (count($data)==0) return $this->error("No se encontró ningun protocolo", 204, []);

            return $this->success($data,count($data),'ok',200);

        }catch (\Throwable $th) {
            throw $th;
        }
    }

}
