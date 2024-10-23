<?php

namespace App\Repositories\TomaMuestrasInv\Encuesta\SedesTomaMuestra;

use Illuminate\Http\Request;

interface SedesTomaMuestraRepositoryInterface
{
public function getSedesTomaMuestra(Request $request);

}
