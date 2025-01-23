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
        Schema::table('participantes', function (Blueprint $table) {
            $table->string('EstadoDePago')->after('Pago')->default('Pendiente'); // Campo nuevo
            $table->string('CursoInscrito')->after('FechadelCurso');            // Campo nuevo
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('participantes', function (Blueprint $table) {
            $table->dropColumn('EstadoDePago');
            $table->dropColumn('CursoInscrito');
        });
    }
};
