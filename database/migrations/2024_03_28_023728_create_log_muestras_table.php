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
        Schema::create('minv_log_muestras', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('minv_formulario_id');
            $table->foreign('minv_formulario_id')->references('id')->on('minv_formulario_muestras');
            $table->unsignedBigInteger('user_id_executed');
            $table->foreign('user_id_executed')->references('id')->on('users');
            $table->unsignedBigInteger('minv_estados_muestras_id');
            $table->foreign('minv_estados_muestras_id')->references('id')->on('minv_estados_muestras');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minv_log_muestras');
    }
};
