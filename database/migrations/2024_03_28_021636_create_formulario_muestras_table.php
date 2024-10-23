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
        Schema::create('minv_formulario_muestras', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->unsignedBigInteger('user_created_id');
            $table->foreign('user_created_id')->references('id')->on('users');
            $table->string('code_paciente');
            $table->unsignedBigInteger('tipo_estudio_id');
            $table->foreign('tipo_estudio_id')->references('id')->on('minv_tipo_estudios');
            $table->unsignedBigInteger('sedes_toma_muestras_id');
            $table->foreign('sedes_toma_muestras_id')->references('id')->on('sedes_toma_muestras');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minv_formulario_muestras');
    }
};
