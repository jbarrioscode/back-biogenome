<?php

namespace App\Repositories\TomaMuestrasInv\Reportes;

interface ReportesRepositoryInterface
{
    public function  getDataPacienteFecha($request,$protocolo_id,$fecha_inicio,$fecha_fin);


}
