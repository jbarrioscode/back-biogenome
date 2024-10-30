<?php

namespace App\Http\Controllers\api\v1\TomaMuestrasInv\Muestras;

use App\Http\Controllers\Controller;
use App\Repositories\TomaMuestrasInv\Protocolos\ProtocoloRepositoryInterface;
use Illuminate\Http\Request;

class ProtocoloController extends Controller
{
    private $protocolo;

    public function __construct(ProtocoloRepositoryInterface $protocolo)
    {
        $this->protocolo = $protocolo;
    }

    public function obtenerTodosProtocolos(Request $request)
    {
        try {

            return $this->protocolo->obtenerTodosProtocolos($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function obtenerProtocosActivosPorUserSede(Request $request,$sede_id)
    {
        try {

            return $this->protocolo->obtenerProtocosActivosPorUserSede($request,$sede_id);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function crearProtocolos(Request $request)
    {
        try {

            return $this->protocolo->crearProtocolos($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function eliminarProtocolo(Request $request,$protocolo_id)
    {
        try {

            return $this->protocolo->eliminarProtocolo($request,$protocolo_id);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function actualizarProtocolo(Request $request,$protocolo_id)
    {
        try {

            return $this->protocolo->actualizarProtocolo($request,$protocolo_id);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

}
