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
        Schema::create('minv_asignacion_muestra_ubicacion', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('ubicacion_estantes_id');
            $table->foreign('ubicacion_estantes_id')->references('id')->on('ubicacion_estantes');
            $table->unsignedBigInteger('user_id_located');
            $table->foreign('user_id_located')->references('id')->on('users');
            $table->unsignedBigInteger('minv_formulario_muestras_id');
            $table->foreign('minv_formulario_muestras_id')->references('id' )->on('minv_formulario_muestras');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minv_asignacion_muestra_ubicacion');
    }
};
