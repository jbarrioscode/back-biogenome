<?php

namespace App\Repositories\TomaMuestrasInv\Protocolos;

use Illuminate\Http\Request;

interface ProtocoloRepositoryInterface
{
    public function obtenerProtocolosActivos(Request $request);
}
