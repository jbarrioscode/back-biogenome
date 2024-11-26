<?php

namespace App\Http\Controllers\api\v1\TomaMuestrasInv\Muestras;

use App\Http\Controllers\Controller;
use App\Http\Requests\TomaMuestrasInv\Muestra\MuestraRequest;
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
    public function guardarMuestra(MuestraRequest $request)
    {
        try {

            return $this->muestraRepository->guardarMuestra($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getPacientePendienteInfoClinica(Request $request)
    {
        try {

            return $this->muestraRepository->getPacientePendienteInfoClinica($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function guardarInfoClinica(Request $request)
    {
        try {

            return $this->muestraRepository->guardarInfoClinica($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function guardarYcerrarInfoClinica(Request $request)
    {
        try {

            return $this->muestraRepository->guardarYcerrarInfoClinica($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getRetornarInfoClinica(Request $request,$muestra_id)
    {
        try {

            return $this->muestraRepository->getRetornarInfoClinica($request,$muestra_id);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
