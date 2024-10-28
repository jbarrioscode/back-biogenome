<?php

namespace App\Repositories\Paciente;

use App\Http\Controllers\Api\v1\Encrypt\EncryptEncuestaInvController;
use App\Models\TomaMuestrasInv\Muestras\FormularioMuestra;
use App\Models\TomaMuestrasInv\Muestras\Muestra;
use App\Models\TomaMuestrasInv\Paciente\ConsentimientoInformadoPaciente;
use App\Models\TomaMuestrasInv\Paciente\Pacientes;
use App\Traits\AuthenticationTrait;
use App\Traits\RequestResponseFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Builder;


class PacienteRepository implements PacienteRepositoryInterface
{
    use RequestResponseFormatTrait;

    public function createPatient(Request $request)
    {

        try {
            DB::beginTransaction();


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
                'ciudad_residencia' => $request->ciudad_residencia,
                'genero' => $request->genero,
                'grupo_sanguineo' => $request->grupo_sanguineo,
                'email' => $request->email,
                'user_id' => \auth()->user()->id
            ]);

            if (!$paciente) return $this->error("Error al registrar paciente", 500, "");

            DB::commit();

            return $this->success($paciente, 1, 'Paciente registrado correctamente', 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function patientInformedConsent(Request $request)
    {
        $rules = [
            'protocolo_id' => 'required|string',
            'paciente_id' => 'required|string',
            'firma' => 'required|string',
        ];

        $messages = [
            'protocolo_id.required' => 'El ID del protocolo está vacio.',
            'paciente_id.required' => 'El ID del paciente está vacio.',
            'firma.required' => 'Firma está vacio.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return $this->error($validator->errors(), 422, []);
        }

        $consentimiento = ConsentimientoInformadoPaciente::create([
            'protocolo_id' => $request->protocolo_id,
            'paciente_id' => $request->paciente_id,
            'firma' => $request->firma,
        ]);

        return $this->success($consentimiento, 1, 'Consentimiento registrado correctamente', 201);

    }

    public function getAllPacientes(Request $request)
    {
        try {
            // Obtén todos los pacientes y sus consentimientos y muestras
            $pacientes = Pacientes::select('pacientes.*',
                'consentimiento_informado_pacientes.created_at as fecha_firma',
                'protocolos.nombre as nombre_protocolo_firmado',
                'protocolos.id as id_protocolo',
                'muestras.created_at as fecha_muestra_tomada')
                ->leftJoin('consentimiento_informado_pacientes', function ($join) {
                    $join->on('pacientes.id', '=', 'consentimiento_informado_pacientes.paciente_id')
                        ->whereNull('consentimiento_informado_pacientes.deleted_at'); // Solo registros no eliminados
                })
                ->leftJoin('protocolos', function ($join) {
                    $join->on('protocolos.id', '=', 'consentimiento_informado_pacientes.protocolo_id')
                        ->whereNull('protocolos.deleted_at'); // Solo registros no eliminados
                })
                ->leftJoin('muestras', function ($join) {
                    $join->on('pacientes.id', '=', 'muestras.paciente_id')
                        ->on('protocolos.id', '=', 'muestras.protocolo_id')
                        ->whereNull('muestras.deleted_at'); // Solo registros no eliminados
                })
                ->get();

            $result = [];
            foreach ($pacientes as $pa) {
                // Crear un nuevo paciente si no existe en el resultado
                if (!isset($result[$pa->id])) {
                    $result[$pa->id] = [
                        'id' => $pa->id,
                        'created_at' => $pa->created_at,
                        'tipo_doc' => $pa->tipo_doc,
                        'numero_documento' => $pa->numero_documento,
                        'primer_nombre' => $pa->primer_nombre,
                        'segundo_nombre' => $pa->segundo_nombre,
                        'primer_apellido' => $pa->primer_apellido,
                        'segundo_apellido' => $pa->segundo_apellido,
                        'fecha_nacimiento' => $pa->fecha_nacimiento,
                        'fecha_expedicion' => $pa->fecha_expedicion,
                        'telefono_celular' => $pa->telefono_celular,
                        'pais_residencia' => $pa->pais_residencia,
                        'departamento_residencia' => $pa->departamento_residencia,
                        'ciudad_residencia' => $pa->ciudad_residencia,
                        'genero' => $pa->genero,
                        'grupo_sanguineo' => $pa->grupo_sanguineo,
                        'email' => $pa->email,
                        'protocolos' => []
                    ];
                }

                if ($pa->nombre_protocolo_firmado) {
                    $result[$pa->id]['protocolos'][] = [
                        'fecha_firma' => $pa->fecha_firma,
                        'nombre_protocolo_firmado' => $pa->nombre_protocolo_firmado,
                        'id_protocolo' => $pa->id_protocolo,
                        'muestra_tomada' => $pa->fecha_muestra_tomada
                    ];
                }
            }

            $result = array_values($result);

            if (count($result) == 0) return $this->error("No se encontró pacientes", 204, []);

            return $this->success($result, count($result), 'ok', 200);
        } catch (\Throwable $th) {
            throw $th;
        }


    }
}
