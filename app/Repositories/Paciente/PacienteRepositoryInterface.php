<?php

namespace App\Repositories\Paciente;

use Illuminate\Http\Request;

interface PacienteRepositoryInterface
{

    public function createPatient(Request $request);
    public function patientInformedConsent(Request $request);
    public function getAllPacientes(Request $request);

}
