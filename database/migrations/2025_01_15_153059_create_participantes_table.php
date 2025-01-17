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
        Schema::create('participantes', function (Blueprint $table) {
            $table->string('N*')->primary();
            $table->string('NombredelPostulante');
            $table->string('Correo');
            $table->string('Telefono');
            $table->string('Edad');
            $table->string('Direccion');
            $table->string('Escolaridad');
            $table->string('Curp');
            $table->string('Empresa');
            $table->string('Puesto');
            $table->string('Pago');
            $table->string('FechadelCurso');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participantes');
    }
};
