<?php

namespace App\Repositories\TomaMuestrasInv\Protocolos;

use App\Models\TomaMuestrasInv\Muestras\Protocolo;
use App\Models\TomaMuestrasInv\Muestras\Protocolo_user_sede;
use App\Traits\RequestResponseFormatTrait;
use Illuminate\Http\Request;

class ProtocoloRepository implements ProtocoloRepositoryInterface
{
    use RequestResponseFormatTrait;
   public function obtenerTodosProtocolos(Request $request)
   {
       try {

           $protocolo=Protocolo::all();

           if (count($protocolo)==0) return $this->error("No se encontró ningun protocolo", 204, []);

           return $this->success($protocolo,count($protocolo),'ok',200);

       }catch (\Throwable $th) {
           throw $th;
       }
   }

    public function obtenerProtocosActivosPorUserSede(Request $request,$sede_id)
    {
        try {

            $protocolo=Protocolo_user_sede::select('stm.id as id_sede', 'stm.descripcion as sede', 'p2.id as protocolo_id', 'p2.nombre as protocolo')
                ->leftJoin('sedes_toma_muestras as stm', 'stm.id', '=', 'protocolo_user_sedes.sede_id')
                ->leftJoin('protocolos as p2', 'p2.id', '=', 'protocolo_user_sedes.protocolo_id')
                ->where('protocolo_user_sedes.user_id', auth()->id())
                 ->where('stm.id', $sede_id)
                ->get();

            $data = $protocolo->groupBy('id_sede')->map(function ($items) {
                return [
                    'sede' => $items->first()->sede,
                    'sede_id' => $items->first()->id_sede,
                    'protocolos' => $items->map(function ($item) {
                        return [
                            'protocolo_id' => $item->protocolo_id,
                            'protocolo' => $item->protocolo,
                        ];
                    })->toArray()
                ];
            })->values()->first();

            if (empty($data)) return $this->error("No se encontró ningun protocolo", 204, []);

            return $this->success($data,count($data),'ok',200);

        }catch (\Throwable $th) {
            throw $th;
        }
    }

    public function crearProtocolos(Request $request)
    {
        try {

            $validator = \Validator::make($request->all(), [
                'nombre' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:protocolos,nombre',
                ],
                'descripcion' => [
                    'required',
                    'string',
                ],
                'tipo_estudio_id' => [
                    'required',
                    'integer',
                ],
            ], [
                'nombre.required' => 'El campo nombre es obligatorio.',
                'nombre.string' => 'El campo nombre debe ser una cadena de texto.',
                'nombre.max' => 'El campo nombre no puede tener más de 255 caracteres.',
                'nombre.unique' => 'El nombre ya existe. Por favor, elija otro.',
                'descripcion.required' => 'El campo descripción es obligatorio.',
                'descripcion.string' => 'El campo descripción debe ser una cadena de texto.',
            ]);

            if ($validator->fails()) {
                return $this->error($validator->errors()->first(), 422, "");
            }

            $protocolo = Protocolo::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'tipo_estudio_id' => $request->tipo_estudio_id,
            ]);

            return $this->success($protocolo, 1, 'Protocolo creado exitosamente', 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function eliminarProtocolo(Request $request, $protocolo_id)
    {
        try {
            $protocolo = Protocolo::find($protocolo_id);

            if (!$protocolo) {
                return $this->error("No se encontró ningún protocolo con el ID: $protocolo_id", 404, []);
            }

            $protocolo->delete();

            return $this->success(null, 0, 'Protocolo eliminado exitosamente', 200);
        } catch (\Throwable $th) {
            return $this->error('Error al eliminar el protocolo: ' . $th->getMessage(), 500);
        }
    }

    public function actualizarProtocolo(Request $request, $protocolo_id)
    {
        try {
            $protocolo = Protocolo::find($protocolo_id);

            if (!$protocolo) {
                return $this->error("No se encontró ningún protocolo con el ID: $protocolo_id", 404, []);
            }

            $request->validate([
                'nombre' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:protocolos,nombre,' . $protocolo_id, // Excluir el protocolo actual de la verificación de unicidad
                ],
                'descripcion' => [
                    'required',
                    'string',
                ],
            ], [
                'nombre.required' => 'El campo nombre es obligatorio.',
                'nombre.string' => 'El campo nombre debe ser una cadena de texto.',
                'nombre.max' => 'El campo nombre no puede tener más de 255 caracteres.',
                'nombre.unique' => 'El nombre ya existe. Por favor, elija otro.',
                'descripcion.required' => 'El campo descripción es obligatorio.',
                'descripcion.string' => 'El campo descripción debe ser una cadena de texto.',
            ]);

            $protocolo->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
            ]);

            return $this->success($protocolo, 1, 'Protocolo actualizado exitosamente', 200);
        } catch (\Throwable $th) {
            return $this->error('Error al actualizar el protocolo: ' . $th->getMessage(), 500);
        }
    }


}
