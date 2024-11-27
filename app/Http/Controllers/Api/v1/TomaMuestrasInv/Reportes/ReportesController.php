<?php

namespace App\Http\Controllers\Api\v1\TomaMuestrasInv\Reportes;

use App\Http\Controllers\Controller;
use App\Repositories\TomaMuestrasInv\Reportes\ReportesRepositoryInterface;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    private $reporte;

    public function __construct(ReportesRepositoryInterface $reporte)
    {
        $this->reporte = $reporte;
    }

    public function getDataMuestrasFecha(Request $request,$protocolo_id,$fecha_inicio,$fecha_fin)
    {
        try {

            return $this->reporte->getDataMuestrasFecha($request,$protocolo_id,$fecha_inicio,$fecha_fin);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getSeguimentoMuestrasPorPrototipo(Request $request,$protocolo_id)
    {
        try {

            return $this->reporte->getSeguimentoMuestrasPorPrototipo($request,$protocolo_id);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getMuestraLog(Request $request,$muestra_id)
    {
        try {

            return $this->reporte->getMuestraLog($request,$muestra_id);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
