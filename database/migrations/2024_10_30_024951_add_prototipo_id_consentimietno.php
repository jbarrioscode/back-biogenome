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
        Schema::table('tipo_consentimiento_informados', function (Blueprint $table) {
            $table->unsignedBigInteger('protocolo_id');
            $table->foreign('protocolo_id')->references('id')->on('protocolos');
            $table->text('consentimiento');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tipo_consentimiento_informados', function (Blueprint $table) {
            $table->dropColumn('protocolo_id');
            $table->dropColumn('consentimiento');
        });
    }
};
