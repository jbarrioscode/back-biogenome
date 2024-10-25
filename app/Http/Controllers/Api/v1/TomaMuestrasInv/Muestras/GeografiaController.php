<?php

namespace App\Http\Controllers\Api\v1\TomaMuestrasInv\Muestras;

use App\Http\Controllers\Controller;
use App\Repositories\TomaMuestrasInv\Geografia\GeografiaRepositoryInterface;
use Illuminate\Http\Request;

class GeografiaController extends Controller
{
    private $sedesTomaMuestraRepository;

    public function __construct(GeografiaRepositoryInterface $sedesTomaMuestraRepository)
    {
        $this->sedesTomaMuestraRepository = $sedesTomaMuestraRepository;
    }

    public function getSedesTomaMuestra(Request $request)
    {
        try {

            return $this->sedesTomaMuestraRepository->getSedesTomaMuestra($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getPais(Request $request)
    {
        try {

            return $this->sedesTomaMuestraRepository->getPais($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getDepartamento(Request $request,$pais_id)
    {
        try {

            return $this->sedesTomaMuestraRepository->getDepartamento($request,$pais_id);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getCiudad(Request $request,$departamento_id)
    {
        try {

            return $this->sedesTomaMuestraRepository->getCiudad($request,$departamento_id);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getCiudadesForPaisId(Request $request,$pais_id)
    {
        try {

            return $this->sedesTomaMuestraRepository->getCiudadesForPaisId($request,$pais_id);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
