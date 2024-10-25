<?php

use App\Http\Controllers\Api\v1\Admin\Authentication\AuthenticationController;
use App\Http\Controllers\Api\v1\Admin\DocumentTypes\DocumentTypesController;
use App\Http\Controllers\Api\v1\Admin\Permissions\PermissionsController;
use App\Http\Controllers\Api\v1\Admin\Roles\RolesController;
use App\Http\Controllers\Api\v1\Admin\Users\UsersController;
use App\Http\Controllers\Api\v1\TomaMuestrasInv\Encuentas\EncuestaController;
use App\Http\Controllers\Api\v1\TomaMuestrasInv\Muestras\SedesTomaMuestraController;
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
Route::middleware(['auth:sanctum', 'verified'])->get('/user', function (Request $request) {
    return $request->user();
});

/** App Routes */
Route::prefix('/v1')->group(function () {

    //Route::middleware(['auth:sanctum', 'verified'])->group(function () {

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

        /* PACIENTE  */


        Route::post('/patient/post/createpatient', [PacienteController::class, 'createPatient']);
        Route::post('/patient/post/patientinformedconsent', [PacienteController::class, 'patientInformedConsent']);

        /*--------------------------------------------------------------------------------*/
        //#####################################################################################
        /*--------------------------------------------------------------------------------*/

        /* MUESTRAS  */

        Route::get('/muestra/get/tipoestudio', [MuestraController::class, 'obtenerTipoEstudio']);

        /*--------------------------------------------------------------------------------*/
        //#####################################################################################
        /*--------------------------------------------------------------------------------*/

        /* PROTOCOLO  */

        Route::get('/muestra/get/protocolo', [ProtocoloController::class, 'obtenerTodosProtocolos']);
        Route::get('/muestra/get/protocolosactivos/{sede_id}', [ProtocoloController::class, 'obtenerProtocosActivosPorUserSede']);


        /*--------------------------------------------------------------------------------*/
        /* SEDES DE TOMA DE MUESTRAS */

        Route::get('/sedesmuestras/get/sedestomademuestras', [SedesTomaMuestraController::class, 'getSedesTomaMuestra']);

        /*--------------------------------------------------------------------------------*/
        /* ENCUESTA */

        Route::get('/encuesta/post/crearEncuesta', [EncuestaController::class, '']);
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
