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
        Schema::create('respuestas_info_clinicas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->date('fecha')->nullable();
            $table->text('respuesta');
            $table->string('unidad')->nullable();
            $table->string('tipo_imagen')->nullable();
            $table->text('observacion')->nullable();
            $table->unsignedBigInteger('muestra_id');
            $table->foreign('muestra_id')->references('id')->on('muestras');
            $table->unsignedBigInteger('pregunta_clinica_id');
            $table->foreign('pregunta_clinica_id')->references('id')->on('preguntas_info_clinicas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuestas_info_clinicas');
    }
};
