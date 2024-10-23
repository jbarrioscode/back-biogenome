<?php

namespace App\Http\Controllers\Api\v1\TomaMuestrasInv\Paciente;

use App\Http\Controllers\Controller;
use App\Repositories\Paciente\PacienteRepositoryInterface;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    private $pacienteRepository;

    public function __construct(PacienteRepositoryInterface $pacienteRepository)
    {
        $this->pacienteRepository = $pacienteRepository;
    }

    public function createPatient(Request $request)
    {
        try {

            return $this->pacienteRepository->createPatient($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function patientInformedConsent(Request $request)
    {
        try {

            return $this->pacienteRepository->patientInformedConsent($request);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
