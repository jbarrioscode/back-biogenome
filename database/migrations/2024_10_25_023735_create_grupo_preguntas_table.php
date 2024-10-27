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
        Schema::create('grupo_preguntas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->integer('orden_grupo');
            $table->unsignedBigInteger('protocolo_id');
            $table->foreign('protocolo_id')->references('id')->on('protocolos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupo_preguntas');
    }
};
