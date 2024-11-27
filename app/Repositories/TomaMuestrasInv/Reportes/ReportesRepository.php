<?php

namespace App\Repositories\TomaMuestrasInv\Reportes;

use App\Models\TomaMuestrasInv\Muestras\EstadosMuestras;
use App\Models\TomaMuestrasInv\Muestras\FormularioMuestra;
use App\Models\TomaMuestrasInv\Muestras\LogMuestras;
use App\Traits\RequestResponseFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportesRepository implements ReportesRepositoryInterface
{
    use RequestResponseFormatTrait;

    public function getDataMuestrasFecha($request, $protocolo_id, $fecha_inicio, $fecha_fin)
    {

        return '';

    }

    public function getSeguimentoMuestrasPorPrototipo(Request $request, $protocolo_id)
    {
        try {

            $muestras = FormularioMuestra::select(
                'p.nombre as protocolo',
                'muestras.created_at as fecha',
                'muestras.code_paciente as codigo_muestra',
                's.nombre as sede',
                'es.estado'
            )
                ->leftJoin('sedes_toma_muestras as s', 's.id', '=', 'muestras.sedes_toma_muestras_id')
                ->leftJoin('protocolos as p', 'p.id', '=', 'muestras.protocolo_id')
                ->leftJoin(DB::raw('(
            SELECT
                lm.muestra_id,
                MAX(lm.estado_id) AS estado_id,
                MAX(est.nombre) AS estado
            FROM
                log_muestras lm
            LEFT JOIN
                minv_estados_muestras est ON est.id = lm.estado_id
            GROUP BY
                lm.muestra_id
            ) as es'), 'es.muestra_id', '=', 'muestras.id')
                ->where('muestras.protocolo_id', $protocolo_id)
                ->get();


            if (count($muestras) == 0) return $this->error("No se encontró muestras", 204, []);

            return $this->success($muestras, count($muestras), 'ok', 200);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getMuestraLog(Request $request, $muestra_id)
    {
        try {

            $estados=EstadosMuestras::select('log_muestras.created_At fecha','users.firstName nombre','users.lastName apellido','minv_estados_muestras.nombre estado')
                ->leftJoin('log_muestras','log_muestras.estado_id','=','minv_estados_muestras.id')
                ->leftJoin('users','users.id','=','log_muestras.user_id')
                ->whereIn('id',[1,2,10,9])
                ->where('log_muestras.muestra_id',$muestra_id)
                ->orderby('minv_estados_muestras.id','asc')
                ->get();


            if (count($estados) == 0) return $this->error("No se encontró muestras", 204, []);

            return $this->success($estados, count($estados), 'ok', 200);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
