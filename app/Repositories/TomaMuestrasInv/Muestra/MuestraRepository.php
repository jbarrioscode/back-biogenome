<?php

namespace App\Repositories\TomaMuestrasInv\Muestra;

use App\Models\TomaMuestrasInv\Encuesta\Respuestas;
use App\Models\TomaMuestrasInv\Muestras\FormularioMuestra;
use App\Models\TomaMuestrasInv\Muestras\LogMuestras;
use App\Models\TomaMuestrasInv\Muestras\TipoEstudio;
use App\Models\TomaMuestrasInv\Paciente\Pacientes;
use App\Traits\RequestResponseFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

    public function guardarMuestra(Request $request)
    {


        DB::beginTransaction();

        try {


            //SE CREA EL FORMULARIO Y LUEGO SE GUARDA LOS DETALLES

            /*
            $patient = Pacientes::all()
                ->where('tipo_doc', '=', $request->tipo_doc)
                ->where('numero_documento', '=', $request->numero_documento)
                ->first();

            /*
            $validacion = ValidacionesEncuestaInvRepository::validarCrearEncuesta($request, $patient->id);

            if ($validacion != "") {
                return $this->error($validacion, 204, []);
            }
            */

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

            foreach ($request->detalle as $det) {

                $detalle = Respuestas::create([
                    'muestras_id' => $formulario->id,
                    'pregunta_id' => $det['pregunta_id'],
                    'respuesta' => $det['respuesta']
                ]);

            }

            LogMuestras::create([
                'muestra_id' => $formulario->id,
                'user_id' => 1,//\auth()->user()->id,//$request->user_created_id,
                'estado_id' => 1,
            ]);

            DB::commit();
            $formulario->detalle = $detalle;
            $formulario->code = $code_muestra.'-'.$request->sedes_toma_muestras_id.'-'.$user_created_id;

            return $this->success($formulario, 1, 'Formulario registrado', 201);

        } catch (\Throwable $th) {
            DB::rollBack();
            return $th;
            throw $th;
        }

    }

}
