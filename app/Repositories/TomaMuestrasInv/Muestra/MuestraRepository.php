<?php

namespace App\Repositories\TomaMuestrasInv\Muestra;

use App\Http\Requests\TomaMuestrasInv\Muestra\MuestraRequest;
use App\Models\TomaMuestrasInv\AsignacionMuestraUbicacion;
use App\Models\TomaMuestrasInv\Encuesta\Respuestas;
use App\Models\TomaMuestrasInv\Encuesta\RespuestasSubpreguntas;
use App\Models\TomaMuestrasInv\Muestras\FormularioMuestra;
use App\Models\TomaMuestrasInv\Muestras\LogMuestras;
use App\Models\TomaMuestrasInv\Muestras\Protocolo_user_sede;
use App\Models\TomaMuestrasInv\Muestras\RespuestasInfoClinica;
use App\Models\TomaMuestrasInv\Muestras\TipoEstudio;
use App\Models\TomaMuestrasInv\Paciente\Pacientes;
use App\Models\TomaMuestrasInv\UbicacionCaja;
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

                foreach ($det['respuesta_subpreguntas'] as $respuestas_subpreguntas){

                    RespuestasSubpreguntas::create([
                        'muestras_id' => $formulario->id,
                        'subpregunta_id' => $respuestas_subpreguntas['subpregunta_id'],
                        'respuesta' => $respuestas_subpreguntas['respuesta']
                    ]);

                }

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

    public function asignarMuestraEstante(Request $request,$muestra_id)
    {
        try {

            $rules = [
                'codigo_muestra' => 'required|string',
                'user_id' => 'required',
                'codigo_ubicacion' => 'required',
            ];

            $messages = [
                'codigo_muestra.required' => 'Codigo de la muestra está vacio.',
                'user_id.required' => 'ID usuario está vacio.',
                'codigo_ubicacion.required' => 'ID de la ubicacion se encuentra vacia.',
            ];

            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                return $this->error($validator->errors(), 422, []);
            }

            $codificacion = explode('-', $request->codigo_muestra);

            $codigo_muestra = preg_split('/([0-9]+)/', $codificacion[0], -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

            /*
            if(isset($codigo_muestra[1])){
                $validacion = ValidacionesEncuestaInvRepository::validarCodificacionMuestra($codificacion,$codigo_muestra,'','CONTRAMUESTRA');
            }else{
                $validacion = ValidacionesEncuestaInvRepository::validarCodificacionMuestra($codificacion,$codigo_muestra,$codificacion[1],'CONTRAMUESTRA');

            }


            if ($validacion != "") {
                return $this->error($validacion, 204, []);
            }
            */

            $codificacionUbicacion = explode('-', $request->codigo_ubicacion);

            if(!isset($codigo_muestra[1])){
                $id_muestra=FormularioMuestra::where('code_paciente',$codificacion[1])->pluck('id')->first();
            }else{
                $id_muestra=$codigo_muestra[1];
            }

            /*
            $validacion2 = ValidacionesEncuestaInvRepository::validarCodigoUbicacion($codificacionUbicacion,$id_muestra);

            if ($validacion2 != "") {
                return $this->error($validacion2, 204, []);
            }
            */

            $idUbicacion= UbicacionCaja::select('ubicacion_cajas.id')
                ->join('ubicacion_estantes', 'ubicacion_cajas.nevera_estante_id', '=', 'ubicacion_estantes.id')
                ->join('ubicacion_bio_bancos', 'ubicacion_bio_bancos.id', '=', 'ubicacion_estantes.ubicacion_bio_bancos_id')
                ->where('ubicacion_cajas.num_caja',$codificacionUbicacion[2])
                ->where('ubicacion_cajas.num_fila',$codificacionUbicacion[3])
                ->first();

            if($idUbicacion == null) return $this->error('Ubicacion no creada', 204, []);


            $asignacion = AsignacionMuestraUbicacion::create([
                'minv_formulario_muestras_id' => $id_muestra,
                'user_id_located' => $request->user_id,
                'caja_nevera_id' => $idUbicacion->id,
            ]);

            LogMuestras::create([
                'minv_formulario_id' => $id_muestra,
                'user_id_executed' => $request->user_id,
                'estado_id' => 6,
            ]);

            DB::commit();

            return $this->success($asignacion, 1, 'Asignacion realizada correctamente', 201);


        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->error('Hay un error' . $th, 204, []);
            throw $th;
        }
    }

}
