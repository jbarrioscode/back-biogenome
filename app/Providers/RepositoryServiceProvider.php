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
use App\Repositories\TomaMuestrasInv\EncuestaInv\EncuestaInvRepository;
use App\Repositories\TomaMuestrasInv\EncuestaInv\EncuestaInvRepositoryInterface;
use App\Repositories\TomaMuestrasInv\Muestra\MuestraRepository;
use App\Repositories\TomaMuestrasInv\Muestra\MuestraRepositoryInterface;
use App\Repositories\TomaMuestrasInv\Protocolos\ProtocoloRepository;
use App\Repositories\TomaMuestrasInv\Protocolos\ProtocoloRepositoryInterface;
use App\Repositories\TomaMuestrasInv\Geografia\GeografiaRepository;
use App\Repositories\TomaMuestrasInv\Geografia\GeografiaRepositoryInterface;
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
            MuestraRepositoryInterface::class,
            MuestraRepository::class
        );
        $this->app->bind(
            GeografiaRepositoryInterface::class,
            GeografiaRepository::class
        );
        $this->app->bind(
            ProtocoloRepositoryInterface::class,
            ProtocoloRepository::class
        );
    }
}
