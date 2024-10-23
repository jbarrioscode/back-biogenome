<?php

namespace App\Providers;

use App\Repositories\Admin\DocumentType\DocumentTypeRepository;
use App\Repositories\Admin\DocumentType\DocumentTypeRepositoryInterface;
use App\Repositories\Admin\Permission\PermissionRepository;
use App\Repositories\Admin\Permission\PermissionRepositoryInterface;
use App\Repositories\Admin\Role\RoleRepository;
use App\Repositories\Admin\Role\RoleRepositoryInterface;
use App\Repositories\Admin\User\UserRepository;
use App\Repositories\Admin\User\UserRepositoryInterface;
use App\Repositories\Paciente\PacienteRepository;
use App\Repositories\Paciente\PacienteRepositoryInterface;
use App\Repositories\TomaMuestrasInv\Encuesta\EncuestaInv\EncuestaInvRepository;
use App\Repositories\TomaMuestrasInv\Encuesta\EncuestaInv\EncuestaInvRepositoryInterface;
use App\Repositories\TomaMuestrasInv\Encuesta\SedesTomaMuestra\SedesTomaMuestraRepository;
use App\Repositories\TomaMuestrasInv\Encuesta\SedesTomaMuestra\SedesTomaMuestraRepositoryInterface;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /*
         * Authentication
         */
        $this->app->bind(
            DocumentTypeRepositoryInterface::class,
            DocumentTypeRepository::class
        );

        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            PermissionRepositoryInterface::class,
            PermissionRepository::class
        );

        $this->app->bind(
            RoleRepositoryInterface::class,
            RoleRepository::class
        );
        /*
         * End Authentication
         */

        $this->app->bind(
            PacienteRepositoryInterface::class,
            PacienteRepository::class
        );
        $this->app->bind(
            EncuestaInvRepositoryInterface::class,
            EncuestaInvRepository::class
        );
        $this->app->bind(
            SedesTomaMuestraRepositoryInterface::class,
            SedesTomaMuestraRepository::class
        );
    }
}
