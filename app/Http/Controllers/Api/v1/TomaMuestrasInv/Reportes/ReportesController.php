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

    public function getDataPacienteFecha(Request $request,$protocolo_id,$fecha_inicio,$fecha_fin)
    {
        try {

            return $this->reporte->getDataPacienteFecha($request,$protocolo_id,$fecha_inicio,$fecha_fin);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
