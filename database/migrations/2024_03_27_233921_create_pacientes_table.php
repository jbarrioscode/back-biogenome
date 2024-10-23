<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {

            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('tipo_doc');
            $table->string('numero_documento');
            $table->string('primer_nombre');
            $table->string('segundo_nombre')->nullable();
            $table->string('primer_apellido');
            $table->string('segundo_apellido');
            $table->date('fecha_nacimiento');
            $table->date('fecha_expedicion')->nullable();
            $table->string('telefono_celular');
            $table->string('pais_residencia')->nullable();
            $table->string('departamento_residencia')->nullable();
            $table->string('ciudad_residencia')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
