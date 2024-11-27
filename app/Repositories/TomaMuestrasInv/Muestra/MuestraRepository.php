<?php

namespace App\Repositories\TomaMuestrasInv\Muestra;

use App\Http\Requests\TomaMuestrasInv\Muestra\MuestraRequest;
use App\Models\TomaMuestrasInv\Encuesta\Respuestas;
use App\Models\TomaMuestrasInv\Muestras\FormularioMuestra;
use App\Models\TomaMuestrasInv\Muestras\LogMuestras;
use App\Models\TomaMuestrasInv\Muestras\Protocolo_user_sede;
use App\Models\TomaMuestrasInv\Muestras\RespuestasInfoClinica;
use App\Models\TomaMuestrasInv\Muestras\TipoEstudio;
use App\Models\TomaMuestrasInv\Paciente\Pacientes;
use App\Traits\RequestResponseFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class MuestraRepository implements MuestraRepositoryInterface
{
    use RequestResponseFormatTrait;

    public function obtenerTipoEstudio(Request $request)
    {
        try {

            $tipoMuestras = TipoEstudio::all();

            if (count($tipoMuestras) == 0) return $this->error("No se encontró ningun tipo de Estudio", 204, []);

            return $this->success($tipoMuestras, count($tipoMuestras), 'ok', 200);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getPacientePendienteInfoClinica(Request $request)
    {
        try {


            $protocolos_id = Protocolo_user_sede::where('user_id', auth()->id())->pluck('protocolo_id');

            $formularios = FormularioMuestra::select('muestras.id',
                'muestras.created_at', 'muestras.updated_at',
                'muestras.deleted_at', 'muestras.code_paciente',
                'sedes_toma_muestras.nombre as sede_toma_muestra'
                , 'pacientes.tipo_doc', 'pacientes.numero_documento')
                ->addSelect(DB::raw('(SELECT est.nombre
                    FROM log_muestras
                    LEFT JOIN minv_estados_muestras est ON est.id = log_muestras.estado_id
                    WHERE muestras.id = log_muestras.muestra_id
                    ORDER BY log_muestras.estado_id DESC
                    LIMIT 1) AS ultimo_estado'))
                ->addSelect(DB::raw('(SELECT est.id
                    FROM log_muestras
                    LEFT JOIN minv_estados_muestras est ON est.id = log_muestras.estado_id
                    WHERE muestras.id = log_muestras.muestra_id
                    ORDER BY log_muestras.estado_id DESC
                    LIMIT 1) AS ultimo_estado_id'))
                ->leftJoin('sedes_toma_muestras', 'sedes_toma_muestras.id', '=', 'muestras.sedes_toma_muestras_id')
                ->leftJoin('pacientes', 'pacientes.id', '=', 'muestras.paciente_id')
               ->whereRaw('(SELECT est.id
                    FROM log_muestras
                    LEFT JOIN minv_estados_muestras est ON est.id = log_muestras.estado_id
                    WHERE muestras.id = log_muestras.muestra_id
                    and log_muestras.deleted_at is null
                    ORDER BY log_muestras.estado_id DESC
                    LIMIT 1) <> 2' )
                ->whereIn('protocolo_id', $protocolos_id->toArray())
                ->orderBy('muestras.id', 'asc')
                ->get();

            if (empty($formularios)) return $this->error("No se encontró pacientes por complemtar información clinica", 204, []);

            return $this->success($formularios, count($formularios), 'ok', 200);


        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function guardarMuestra(MuestraRequest $request)
    {
        DB::beginTransaction();

        try {

            $validacion = ValidacionesMuestrasRepository::validarCreacionMuestra($request, $request->paciente_id);

            if ($validacion != "") {
                return $this->error($validacion, 204, []);
            }

            $user_created_id = \auth()->user()->id;

            do {
                $code_muestra = strtoupper(Str::random(4, 'abcdefghijklmnopqrstuvwxyz0123456789'));
            } while (count(FormularioMuestra::where('code_paciente', '=', $code_muestra)->get()) === 1);


            $formulario = FormularioMuestra::create([
                'paciente_id' => $request->paciente_id,//$patient->id,
                'user_created_id' => $user_created_id,
                'code_paciente' => $code_muestra,
                'protocolo_id' => $request->protocolo_id,
                'sedes_toma_muestras_id' => $request->sedes_toma_muestras_id,
            ]);

            $validacion = ValidacionesMuestrasRepository::validarRespuestasMuestras($request->detalle,$request->protocolo_id);

            if ($validacion != "") {
                return $this->error($validacion, 204, []);
            }

            foreach ($request->detalle as $det) {

                $detalle = Respuestas::create([
                    'muestras_id' => $formulario->id,
                    'pregunta_id' => $det['pregunta_id'],
                    'respuesta' => $det['respuesta']
                ]);

            }

            LogMuestras::create([
                'muestra_id' => $formulario->id,
                'user_id' => \auth()->user()->id,//$request->user_created_id,
                'estado_id' => 1,
            ]);

            DB::commit();
            $formulario->detalle = $detalle;
            $formulario->code = $code_muestra . '-' . $request->sedes_toma_muestras_id . '-' . $user_created_id;

            return $this->success($formulario, 1, 'Formulario registrado', 201);

        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
            throw $th;
        }

    }

    public function guardarInfoClinica(Request $request)
    {
        DB::beginTransaction();

        try {
            $rules = [
                'muestra_id' => 'required',
                'user_id' => 'required',
            ];

            $messages = [
                'muestra_id.required' => 'La muestra está vacio.',
                'user_id.required' => 'user id está vacio.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->error($validator->errors(), 422, []);
            }

            $validacion = ValidacionesMuestrasRepository::validarRespuestasClinicas($request->datos, $request->muestra_id);

            if ($validacion != "") {
                return $this->error($validacion, 204, []);
            }

            $respuestas = [];

            foreach ($request->datos as $inf) {

                $value = null;
                if (isset($inf['valor'])) {
                    $value = $inf['valor'];
                }

                $data = [
                    'fecha' => $inf['fecha'],
                    'respuesta' => $inf['respuesta'],
                    'pregunta_clinica_id' => $inf['pregunta_clinica_id'],
                    'valor' => $value,
                    'muestra_id' => $request->muestra_id,
                ];

                switch ($inf['pregunta_clinica_id']) {
                    case 4:
                        $data['unidad'] = $inf['unidad'];
                        break;
                    case 6:
                        $data['tipo_imagen'] = $inf['tipo_imagen'];
                        break;
                }

                $respuestas[] = RespuestasInfoClinica::create($data);
            }


            DB::commit();

            return $this->success($respuestas, 1, 'Respuestas registradas correctamente', 201);

        } catch (\Throwable $th) {
            DB::rollBack();
            //return $this->error('Hay un error con el ID de la muestra: ' . $idErrorMuestra, 204, []);
            throw $th;
        }
    }

    public function guardarYcerrarInfoClinica(Request $request)
    {
        try {
            $rules = [
                'muestra_id' => 'required',
                'user_id' => 'required',
            ];

            $messages = [
                'muestra_id.required' => 'La muestra está vacio.',
                'user_id.required' => 'user id está vacio.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->error($validator->errors(), 422, []);
            }

            $log=LogMuestras::create([
                'muestra_id' => $request->muestra_id,
                'user_id' => $request->user_id,
                'estado_id' => 2,
            ]);
            return $this->success($log, 1, 'Historia clinica cerrada correctamente', 201);

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function getRetornarInfoClinica(Request $request,$muestra_id)
    {

        try {

            $respuesta=RespuestasInfoClinica::select('respuestas_info_clinicas.*','preguntas_info_clinicas.pregunta','preguntas_info_clinicas.*')
                ->leftjoin('preguntas_info_clinicas','preguntas_info_clinicas.id','=','respuestas_info_clinicas.pregunta_clinica_id')
                ->where('muestra_id',$muestra_id)->get();

            if (empty($respuesta)) return $this->error("No se encontró respuesta clinica", 204, []);

            return $this->success($respuesta, count($respuesta), 'ok', 200);

        } catch (\Throwable $th) {
            throw $th;
        }


    }

}
