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
        Schema::table('consentimiento_informado_pacientes', function (Blueprint $table) {
            $table->string('nombre_completo')->nullable();
            $table->string('tipo_documento')->nullable();
            $table->string('documento')->nullable();
            $table->string('relacion_sujeto')->nullable();
            $table->string('direccion')->nullable();
            $table->unsignedBigInteger('firmante_id')->nullable();
            $table->foreign('firmante_id')->references('id')->on('firmante');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consentimiento_informado_pacientes', function (Blueprint $table) {
            $table->dropColumn('nombre_completo');
            $table->dropColumn('tipo_documento');
            $table->dropColumn('documento');
            $table->dropColumn('relacion_sujeto');
            $table->dropColumn('direccion');
            $table->dropColumn('firmante_id');
        });
    }
};
