<?php

namespace App\Repositories\TomaMuestrasInv\SedesTomaMuestra;

use Illuminate\Http\Request;

interface SedesTomaMuestraRepositoryInterface
{
public function getSedesTomaMuestra(Request $request);

}
