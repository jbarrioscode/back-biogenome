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

    public function obtenerProtocolosActivos(Request $request)
    {
        try {

            return $this->protocolo->obtenerProtocolosActivos($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
