<?php

namespace App\Repositories\Paciente;

use Illuminate\Http\Request;

interface PacienteRepositoryInterface
{

    public function createPatient(Request $request);
    public function patientInformedConsent(Request $request);
    public function getAllPacientes(Request $request);

    public function getFirmantes(Request $request);

    public function getConsentimientoPorProtocolo(Request $request,$protocolo_id);

}
