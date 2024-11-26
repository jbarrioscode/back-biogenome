<?php

namespace App\Repositories\TomaMuestrasInv\Muestra;

use App\Models\TomaMuestrasInv\Muestras\FormularioMuestra;
use App\Models\TomaMuestrasInv\Muestras\PreguntasInfoClinica;
use App\Models\TomaMuestrasInv\Muestras\RespuestasInfoClinica;

class ValidacionesMuestrasRepository
{

    public static function validarRespuestasClinicas($data, $muestra_id)
    {
        {
            if (FormularioMuestra::where('id', $muestra_id)->count() == 0) {
                return 'No existe encuesta con este ID';
            }

            foreach ($data as $inf) {

                if (RespuestasInfoClinica::where('muestra_id', $muestra_id)
                        ->where('pregunta_clinica_id', $inf['pregunta_clinica_id']
                        )->count() > 0) {

                    return 'Ya existe información de la pregunta: ' . $inf['pregunta_clinica_id'] . ' de la historia clinica';
                }
            }

            /*
            //------------------------------------------
            $preguntaIds = range(1, 9);
            $preguntasPresentes = array_column($data, 'pregunta_clinica_id');

            foreach ($preguntaIds as $preguntaId) {
                if (!in_array($preguntaId, $preguntasPresentes)) {
                    $pregunta = PreguntasInfoClinica::find($preguntaId);
                    return "Falta al menos un registro para la pregunta: " . $pregunta->pregunta;
                }

            }

            foreach ($data as $inf) {

                if (!isset($inf['respuesta'])) {
                    return 'Pregunta ' . $inf['pregunta_clinica_id'] . ' debe contener respuesta';
                }

                if ($inf['pregunta_clinica_id'] != 1 && $inf['pregunta_clinica_id'] != 7 && $inf['pregunta_clinica_id'] != 8 && $inf['pregunta_clinica_id'] != 9) {

                    if (!isset($inf['fecha'])) {
                        return 'Pregunta ' . $inf['pregunta_clinica_id'] . ' debe contener fecha';
                    }

                    switch ($inf['pregunta_clinica_id']) {
                        case 4:
                            if (!isset($inf['unidad'])) {
                                return "Se requiere 'unidad' para la pregunta_clinica_id 4";
                            }
                            break;
                        case 6:
                            if (!isset($inf['tipo_imagen'])) {
                                return "Se requiere 'tipo imagen' para la pregunta_clinica_id 6";
                            }
                            break;
                    }//


                }


            }
            */
        }

        return '';
    }
    public static function validarCreacionMuestra($request, $paciente_id)
    {

        if (count(FormularioMuestra::where('paciente_id', '=', $paciente_id)
                ->where('protocolo_id',$request->protocolo_id)->get()) > 0) {
            return 'Paciente ya se encuentra participando a este protocolo';
        }

        foreach ($request->detalle as $det) {

            if($det->muestra_id == null || $det->pregunta_id == '' || $det->respuesta == null){
                return 'Respuestas se encuentran incompletas';
            }

        }

    }
}

