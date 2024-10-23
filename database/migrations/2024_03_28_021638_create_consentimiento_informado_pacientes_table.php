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
        Schema::create('consentimiento_informado_pacientes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('tipo_consentimiento_id');
            $table->foreign('tipo_consentimiento_id')->references('id')->on('tipo_consentimiento_informados');
            $table->unsignedBigInteger('tipo_estudio_id');
            $table->foreign('tipo_estudio_id')->references('id')->on('minv_tipo_estudios');
            $table->unsignedBigInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes');
            $table->text('firma');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consentimiento_informado_pacientes');
    }
};
