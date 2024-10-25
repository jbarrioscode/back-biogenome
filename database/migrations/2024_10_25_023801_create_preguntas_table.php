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
        Schema::create('preguntas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->unsignedBigInteger('tipo_de_preguntas_id');
            $table->foreign('tipo_de_preguntas_id')->references('id')->on('tipo_de_preguntas');
            $table->unsignedBigInteger('grupo_pregunta_id');
            $table->foreign('grupo_pregunta_id')->references('id')->on('grupo_preguntas');
            $table->unsignedBigInteger('protocolo_id');
            $table->foreign('protocolo_id')->references('id')->on('protocolos');
            $table->integer('orden_pregunta');


            // CREAR UNA TABLA DE PROPIEDADES DE PREGUNTAS:
            //          * ICONOS
            //          * PLACEHOLDER
            //          *

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preguntas');
    }
};
