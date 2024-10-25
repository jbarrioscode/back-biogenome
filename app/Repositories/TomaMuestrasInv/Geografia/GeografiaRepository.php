<?php

namespace App\Repositories\TomaMuestrasInv\Geografia;

use App\Models\GeneralSettings\Country;
use App\Models\TomaMuestrasInv\Geografia\CiudadesMunicipios;
use App\Models\TomaMuestrasInv\Geografia\DepartamentosRegiones;
use App\Models\TomaMuestrasInv\Muestras\SedesTomaMuestra;
use App\Traits\RequestResponseFormatTrait;
use Illuminate\Http\Request;

class GeografiaRepository implements GeografiaRepositoryInterface
{
    use RequestResponseFormatTrait;
public function getSedesTomaMuestra(Request $request)
{
    try {

       $sedes=SedesTomaMuestra::all();

        if (count($sedes)==0) return $this->error("No se encontró sedes", 204, []);

        return $this->success($sedes,count($sedes),'ok',200);

    }catch (\Throwable $th) {
        throw $th;
    }

}

    public function getPais(Request $request)
    {
        try {

            $pais = Country::all();

            if (count($pais) == 0) return $this->error("No se encontró ningun pais", 204, []);

            return $this->success($pais, count($pais), 'ok', 200);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getDepartamento(Request $request, $pais_id)
    {
        try {

            $dpto = DepartamentosRegiones::where('pais_id',$pais_id)->get();

            if (count($dpto) == 0) return $this->error("No se encontró ningun departamento/region", 204, []);

            return $this->success($dpto, count($dpto), 'ok', 200);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getCiudad(Request $request, $departamento_id)
    {
        try {

            $city = CiudadesMunicipios::where('departamentos_regiones_id',$departamento_id)->get();

            if (count($city) == 0) return $this->error("No se encontró ninguna ciudad/municipio", 204, []);

            return $this->success($city, count($city), 'ok', 200);

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getCiudadesForPaisId(Request $request, $pais_id)
    {
        try {

            $city = DepartamentosRegiones::select('ciudades_municipios.name')
                ->leftJoin('ciudades_municipios', 'departamentos_regiones.id', '=', 'ciudades_municipios.departamentos_regiones_id')
                ->where('departamentos_regiones.pais_id',$pais_id)
                ->orderBy('ciudades_municipios.name','asc')
                ->get();

            if (count($city) == 0) return $this->error("No se encontró ninguna ciudad de este pais.", 204, []);

            return $this->success($city, count($city), 'ok', 200);

        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
