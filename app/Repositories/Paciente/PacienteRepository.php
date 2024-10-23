<?php

namespace App\Repositories\Paciente;

use App\Http\Controllers\Api\v1\Encrypt\EncryptEncuestaInvController;
use App\Models\TomaMuestrasInv\Paciente\ConsentimientoInformadoPaciente;
use App\Models\TomaMuestrasInv\Paciente\Pacientes;
use App\Traits\AuthenticationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PacienteRepository implements PacienteRepositoryInterface
{
    use AuthenticationTrait;

    public function createPatient(Request $request)
    {

        try {
            $rules = [
                'tipo_doc' => 'required|string',
                'numero_documento' => 'required|string|unique:pacientes',
                'primer_nombre' => 'required|string',
                'primer_apellido' => 'required|string',
                'segundo_apellido' => 'required|string',
                'telefono_celular' => 'required|string',
                'fecha_nacimiento' => 'required|string',
                'fecha_expedicion' => 'required|string',
            ];

            $messages = [
                'tipo_doc.required' => 'El nombre es obligatorio.',
                'numero_documento.unique' => 'El numero de documento ya se encuentra registrado.',
                'numero_documento.required' => 'Numero de documento esta vacio.',
                'primer_nombre.required' => 'Primer nombre está vacio.',
                'telefono_celular.required' => 'Telefono celular está vacio.',
                'primer_apellido.required' => 'Primer apellido está vacio.',
                'segundo_apellido.required' => 'Segundo apellido está vacio.',
                'fecha_nacimiento.required' => 'fecha de nacimiento está vacio.',
                'fecha_expedicion.required' => 'fecha de expedición está vacio.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->error($validator->errors(), 422, []);
            }


            $paciente = Pacientes::create([
                'tipo_doc' => $request->tipo_doc,
                'numero_documento' => $request->numero_documento,
                'telefono_celular' => $request->telefono_celular,
                'primer_nombre' => EncryptEncuestaInvController::encryptar($request->primer_nombre),
                'segundo_nombre' => EncryptEncuestaInvController::encryptar($request->segundo_nombre),
                'primer_apellido' => EncryptEncuestaInvController::encryptar($request->primer_apellido),
                'segundo_apellido' => EncryptEncuestaInvController::encryptar($request->segundo_apellido),
                'fecha_nacimiento' => $request->fecha_nacimiento,
                'fecha_expedicion' => $request->fecha_expedicion,
                'pais_residencia' => $request->pais_residencia,
                'departamento_residencia' => $request->departamento_residencia,
                'ciudad_residencia' => $request->ciudad_residencia
            ]);

            if (!$paciente) return $this->error("Error al registrar paciente", 500, "");

            return $this->success($paciente, 1, 'Paciente registrado correctamente', 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function patientInformedConsent(Request $request)
    {
        $rules = [
            'tipo_consentimiento_id' => 'required|string',
            'tipo_estudio_id' => 'required|string',
            'paciente_id' => 'required|string',
            'firma' => 'required|string',
        ];

        $messages = [
            'tipo_consentimiento_id.required' => 'El tipo de consentimiento es obligatorio.',
            'tipo_estudio_id.required' => 'El ID del tipo de estudio está vacio.',
            'paciente_id.required' => 'El ID del paciente está vacio.',
            'firma.required' => 'Firma está vacio.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors(), 422, []);
        }

        $consentimiento = ConsentimientoInformadoPaciente::create([
            'tipo_consentimiento_id' => $request->tipo_consentimiento_id,
            'tipo_estudio_id' => $request->tipo_estudio_id,
            'paciente_id' => $request->paciente_id,
            'firma' => $request->firma,
        ]);

        return $this->success($consentimiento, 1, 'Consentimiento registrado correctamente', 201);

    }
}
