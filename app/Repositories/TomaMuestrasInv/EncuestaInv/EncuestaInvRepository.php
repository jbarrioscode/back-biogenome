<?php

namespace App\Repositories\TomaMuestrasInv\EncuestaInv;

use App\Models\TomaMuestrasInv\Encuesta\GrupoPregunta;
use App\Models\TomaMuestrasInv\Encuesta\Preguntas;
use App\Models\TomaMuestrasInv\Encuesta\PropiedadesPreguntas;
use App\Models\TomaMuestrasInv\Encuesta\PropiedadesSubPreguntas;
use App\Models\TomaMuestrasInv\Encuesta\SubPreguntas;
use App\Traits\RequestResponseFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EncuestaInvRepository implements EncuestaInvRepositoryInterface
{
    use RequestResponseFormatTrait;
    public function renderizarEncuesta(Request $request,$protocolo_id)
    {

        try {
            //DB::beginTransaction();

            $grupoPreguntas=GrupoPregunta::where('protocolo_id',$protocolo_id)
                ->orderBy('orden_grupo','asc')->get();

            if (count($grupoPreguntas)==0) return $this->error("No se encontró preguntas", 204, []);


            foreach ($grupoPreguntas as $gru){

                $preguntas= Preguntas::select('preguntas.orden_pregunta','preguntas.nombre as nombre_pregunta','preguntas.descripcion as descripcion_pregunta','preguntas.id as id_pregunta'
                    ,'tipo_de_preguntas.id as id_tipo_pregunta','tipo_de_preguntas.nombre as tipo_pregunta')
                    ->where('preguntas.grupo_pregunta_id',$gru->id)
                    ->leftJoin('tipo_de_preguntas', 'tipo_de_preguntas.id', '=', 'preguntas.tipo_de_preguntas_id')
                    ->orderBy('orden_pregunta','asc')
                    ->get();

                foreach ($preguntas as $preg){

                    $propiedades = PropiedadesPreguntas::select('propiedades_preguntas.parametro as parametro'
                        ,'propiedades_preguntas.pregunta_id as pregunta_id'
                        ,'propiedades_preguntas.propiedad as propiedad')
                        ->where('pregunta_id',$preg->id_pregunta)->get();


                    $preg->propiedades=$propiedades;

                    $subpreguntas = SubPreguntas::select('sub_preguntas.nombre as nombre_subpregunta'
                        ,'sub_preguntas.id as id_subpregunta'
                        ,'sub_preguntas.condicion_seleccion'
                        ,'tipo_de_preguntas.id as id_tipo_pregunta','tipo_de_preguntas.nombre as tipo_pregunta')
                        ->leftJoin('tipo_de_preguntas', 'tipo_de_preguntas.id', '=', 'sub_preguntas.tipo_de_preguntas_id')
                        ->where('pregunta_id',$preg->id_pregunta)->get();

                    if(count($subpreguntas) != 0){

                        foreach ($subpreguntas as $sub){

                            $propiedadesSubpregunta=PropiedadesSubPreguntas::select('propiedades_sub_preguntas.parametro as parametro'
                                ,'propiedades_sub_preguntas.sub_pregunta_id as sub_pregunta_id'
                                ,'propiedades_sub_preguntas.propiedad as propiedad')
                                ->where('sub_pregunta_id',$sub->id_subpregunta)->get();

                            $sub->propriedadesSubPregunta=$propiedadesSubpregunta;

                        }


                    }

                    $preg->subpreguntas=$subpreguntas;
                }

                $gru->preguntas=$preguntas;



            }

            return $this->success($grupoPreguntas,count($grupoPreguntas),'ok',200);

            //DB::commit();
        } catch (\Throwable $th) {
            //DB::rollBack();
            throw $th;
        }
    }

}
