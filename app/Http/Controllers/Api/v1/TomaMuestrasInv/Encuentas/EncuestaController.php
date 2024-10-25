<?php

namespace App\Http\Controllers\Api\v1\TomaMuestrasInv\Encuentas;

use App\Http\Controllers\Controller;
use App\Repositories\TomaMuestrasInv\EncuestaInv\EncuestaInvRepositoryInterface;
use Illuminate\Http\Request;

class EncuestaController extends Controller
{
    private $encuestaRepository;

    public function __construct(EncuestaInvRepositoryInterface $encuestaRepository)
    {
        $this->encuestaRepository = $encuestaRepository;
    }

    public function renderizarEncuesta(Request $request,$protocolo_id)
    {
        try {

            return $this->encuestaRepository->renderizarEncuesta($request,$protocolo_id);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
