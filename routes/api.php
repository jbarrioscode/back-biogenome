<?php

use App\Http\Controllers\Api\v1\Admin\Authentication\AuthenticationController;
use App\Http\Controllers\Api\v1\Admin\DocumentTypes\DocumentTypesController;
use App\Http\Controllers\Api\v1\Admin\Permissions\PermissionsController;
use App\Http\Controllers\Api\v1\Admin\Roles\RolesController;
use App\Http\Controllers\Api\v1\Admin\Users\UsersController;
use App\Http\Controllers\Api\v1\TomaMuestrasInv\Encuentas\EncuestaController;
use App\Http\Controllers\Api\v1\TomaMuestrasInv\Muestras\GeografiaController;
use App\Http\Controllers\Api\v1\TomaMuestrasInv\Paciente\PacienteController;
use App\Http\Controllers\Api\v1\TomaMuestrasInv\Muestras\MuestraController;
use App\Http\Controllers\Api\v1\TomaMuestrasInv\Muestras\ProtocoloController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
Route::middleware(['auth:sanctum', 'verified'])->get('/user', function (Request $request) {
    return $request->user();
});
*/
/** App Routes */
Route::prefix('/v1')->group(function () {


    //Route::middleware(['auth', 'verified'])->group(function () {

        /* ADMINISTRADOR*/
        /** Routes For User Management  */
        Route::get('users', [UsersController::class, 'getUsersList']);
        Route::post('users/store', [AuthenticationController::class, 'register']);
        Route::delete('user/inactivate/{id}', [UsersController::class, 'inactivateUserById']);
        Route::post('users/change-password', [UsersController::class, 'updatePassword']);
        Route::put('users/update/{userid}', [UsersController::class, 'updateUser']);

        /** Routes For Handle Permission Management  */
        Route::get('permissions', [PermissionsController::class, 'getPermissionList']);
        Route::post('permissions/store', [PermissionsController::class, 'savePermission']);
        Route::delete('permissions/delete/{id}', [PermissionsController::class, 'inactivatePermissionById']);

        /** Routes For Handle Role Management  */
        Route::get('roles', [RolesController::class, 'getRoleList']);
        Route::post('roles/store', [RolesController::class, 'saveRole']);
        Route::put('roles/edit/{id}', [RolesController::class, 'modifyRoleById']);
        Route::delete('roles/delete/{id?}', [RolesController::class, 'inactivateRoleById']);

        /* Routes For Handle DocumentType */
        Route::get('document-types', [DocumentTypesController::class, 'getDocumentTypeRepository']);

        /*--------------------------------------------------------------------------------*/
        //#####################################################################################
        /*--------------------------------------------------------------------------------*/

        /* PAISES - DEPARTAMENTOS - CIUDADES/MUNICIPIOS  */

        Route::get('geografia/getpais', [GeografiaController::class, 'getPais']);
        Route::get('geografia/getdepartamento/{pais_id}', [GeografiaController::class, 'getDepartamento']);
        Route::get('geografia/getciudad/{departamento_id}', [GeografiaController::class, 'getCiudad']);
        Route::get('geografia/getciudadforpaisid/{pais_id}', [GeografiaController::class, 'getCiudadesForPaisId']);

        Route::get('geografia/getallciudad', [GeografiaController::class, 'getAllCiudad']);
        Route::get('geografia/getalldepartamento', [GeografiaController::class, 'getAllDepartamento']);

        /*--------------------------------------------------------------------------------*/
        //#####################################################################################
        /*--------------------------------------------------------------------------------*/

        /*--------------------------------------------------------------------------------*/
        /* SEDES DE TOMA DE MUESTRAS */

        Route::get('/sedesmuestras/get/sedes-toma-de-muestras', [GeografiaController::class, 'getSedesTomaMuestra']);
        Route::post('/sedesmuestras/post/sedes-toma-de-muestras', [GeografiaController::class, 'crearSedeTomaMuestra']);


        /* PACIENTE  */


        Route::post('/patient/post/create-patient', [PacienteController::class, 'createPatient']); // Implemented in frontend
        Route::post('/patient/post/patient-informed-consent', [PacienteController::class, 'patientInformedConsent']);
        Route::get('/patient/get/todos-pacientes', [PacienteController::class, 'getAllPacientes']); // Implemented in frontend


        /*--------------------------------------------------------------------------------*/
        //#####################################################################################
        /*--------------------------------------------------------------------------------*/

        /* MUESTRAS  */

        Route::get('/muestra/get/tipo-estudio', [MuestraController::class, 'obtenerTipoEstudio']);
        Route::post('/muestra/post/guardar-muestra', [MuestraController::class, 'guardarMuestra']);
        Route::post('/muestra/post/guardar-info-clinica', [MuestraController::class, 'guardarInfoClinica']);



    /*--------------------------------------------------------------------------------*/
        //#####################################################################################
        /*--------------------------------------------------------------------------------*/

        /* PROTOCOLO  */

        Route::get('/protocolos/get/protocolo', [ProtocoloController::class, 'obtenerTodosProtocolos']);
        Route::get('/protocolos/get/protocolos-activos/{sede_id}', [ProtocoloController::class, 'obtenerProtocosActivosPorUserSede']);
        Route::post('/protocolos/post/crear-protocolos', [ProtocoloController::class, 'crearProtocolos']);
        Route::delete('/protocolos/delete/protocolo/{id}', [ProtocoloController::class, 'eliminarProtocolo']);
        Route::put('/protocolos/put/protocolo/{id}', [ProtocoloController::class, 'actualizarProtocolo']);




    /*--------------------------------------------------------------------------------*/
        /* ENCUESTA */

        Route::get('/encuesta/get/renderizar-encuesta/{protocolo_id}', [EncuestaController::class, 'renderizarEncuesta']);




    /*  */
    //});

    /* ------------------------------------------------------------------------------------
    /** Clean Cache Route */
    Route::get('/clear', function () {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
    });

});
