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
        Schema::create('minv_detalle_encuestas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('minv_formulario_id');
            $table->foreign('minv_formulario_id')->references('id')->on('minv_formulario_muestras');
            $table->string('altura');
            $table->string('peso');
            $table->string('etnia');
            $table->string('pais_nacimiento');
            $table->string('ciudad_nacimiento');
            $table->string('nacionalidad_abuelo_materno')->nullable();
            $table->string('nacionalidad_abuela_materno')->nullable();
            $table->string('nacionalidad_abuelo_paterno')->nullable();
            $table->string('nacionalidad_abuela_paterno')->nullable();
            $table->string('nacionalidad_paciente');
            $table->string('es_fumador');
            $table->string('presion_arterial');
            $table->string('medicamento_para_presion_arterial')->nullable();
            $table->string('altos_niveles_colesterol');
            $table->string('frecuencia_consumo_bebidas_alcoholicas');
            $table->string('afeccion_o_enfermededad_cronica__madre');
            $table->string('cual_afeccion_o_enfermededad_cronica__madre')->nullable();
            $table->string('afeccion_o_enfermededad_cronica__padre');
            $table->string('cual_afeccion_o_enfermededad_cronica__padre')->nullable();
            $table->string('afeccion_o_enfermededad_cronica__hermanos');
            $table->string('cual_afeccion_o_enfermededad_cronica__hermanos')->nullable();
            $table->string('enfermedades_cronicas');
            $table->string('enfermedades_pulmonares');
            $table->string('enfermedades_endocrinas_metabolicas');
            $table->string('enfermedades_digestivas');
            $table->string('enfermedades_renales');
            $table->string('enfermedades_neurologicas');
            $table->string('enfermedades_dermatologicas');
            $table->string('enfermedades_reumaticas');
            $table->string('diagnosticado_cancer_ultimos_cinco_anos');
            $table->string('cancer_diagnosticado')->nullable();
            $table->string('afecciones_diagnosticadas');
            $table->string('analisis_sangre_ultimos_seis_meses');
            $table->string('prueba_positiva_covid_19');
            $table->string('vacunacion_covid_19');
            $table->string('tipo_vacuna_recibida')->nullable();
            $table->string('cantidad_dosis_vacunacion_recibida')->nullable();
            $table->text('sintomas_tenidos_por_covid')->nullable();
            $table->string('hospitalizado_por_covid_19');
            $table->string('tiempo_recuperacion_covid_19')->nullable();
            $table->text('sintomas_q_persisten_por_covid_19')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minv_detalle_encuestas');
    }
};
