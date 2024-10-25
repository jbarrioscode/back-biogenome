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
        Schema::create('opciones_sub_preguntas', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->text('opcion');
            $table->unsignedBigInteger('sub_preguntas_id');
            $table->foreign('sub_preguntas_id')->references('id')->on('sub_preguntas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opciones_sub_preguntas');
    }
};
