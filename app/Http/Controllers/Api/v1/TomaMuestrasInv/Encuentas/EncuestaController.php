<?php

namespace App\Http\Controllers\Api\v1\TomaMuestrasInv\Encuentas;

use App\Http\Controllers\Controller;
use App\Repositories\TomaMuestrasInv\Encuesta\EncuestaInv\EncuestaInvRepositoryInterface;
use Illuminate\Http\Request;

class EncuestaController extends Controller
{
    private $encuestaRepository;

    public function __construct(EncuestaInvRepositoryInterface $encuestaRepository)
    {
        $this->encuestaRepository = $encuestaRepository;
    }

    public function crearEncuesta(Request $request)
    {
        try {

            return $this->encuestaRepository->crearEncuesta($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
