<?php

namespace App\Repositories\TomaMuestrasInv\Reportes;

use Illuminate\Http\Request;

interface ReportesRepositoryInterface
{
    public function  getDataMuestrasFecha(Request $request,$protocolo_id,$fecha_inicio,$fecha_fin);
    public function getSeguimentoMuestrasPorPrototipo(Request $request,$protocolo_id);
    public function getMuestraLog(Request $request,$protocolo_id);


}
