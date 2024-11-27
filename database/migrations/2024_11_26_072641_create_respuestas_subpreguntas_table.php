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
        Schema::create('respuestas_subpreguntas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->text('respuesta');
            $table->unsignedBigInteger('subpregunta_id');
            $table->foreign('subpregunta_id')->references('id')->on('sub_preguntas');
            $table->unsignedBigInteger('muestras_id');
            $table->foreign('muestras_id')->references('id')->on('muestras');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respuestas_subpreguntas');
    }
};
