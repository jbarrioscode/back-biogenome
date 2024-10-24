<?php

namespace App\Http\Controllers\api\v1\TomaMuestrasInv\Muestras;

use App\Http\Controllers\Controller;
use App\Repositories\TomaMuestrasInv\Muestra\MuestraRepositoryInterface;
use Illuminate\Http\Request;

class MuestraController extends Controller
{
    private $muestraRepository;

    public function __construct(MuestraRepositoryInterface $muestraRepository)
    {
        $this->muestraRepository = $muestraRepository;
    }

    public function obtenerTipoEstudio(Request $request)
    {
        try {

            return $this->muestraRepository->obtenerTipoEstudio($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
