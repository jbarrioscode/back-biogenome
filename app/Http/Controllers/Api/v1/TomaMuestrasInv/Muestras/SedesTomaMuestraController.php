<?php

namespace App\Http\Controllers\Api\v1\TomaMuestrasInv\Muestras;

use App\Http\Controllers\Controller;
use App\Repositories\TomaMuestrasInv\SedesTomaMuestra\SedesTomaMuestraRepositoryInterface;
use Illuminate\Http\Request;

class SedesTomaMuestraController extends Controller
{
    private $sedesTomaMuestraRepository;

    public function __construct(SedesTomaMuestraRepositoryInterface $sedesTomaMuestraRepository)
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
}
