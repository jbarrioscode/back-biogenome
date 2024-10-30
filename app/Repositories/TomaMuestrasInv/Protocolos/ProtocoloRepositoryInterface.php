<?php

namespace App\Repositories\TomaMuestrasInv\Protocolos;

use Illuminate\Http\Request;

interface ProtocoloRepositoryInterface
{
    public function obtenerTodosProtocolos(Request $request);
    public function obtenerProtocosActivosPorUserSede(Request $request,$sede_id);
    public function crearProtocolos(Request $request);
    public function actualizarProtocolo(Request $request, $protocolo_id);


}
