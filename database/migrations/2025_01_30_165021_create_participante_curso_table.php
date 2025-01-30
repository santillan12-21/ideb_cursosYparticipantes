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
    Schema::create('participante_curso', function (Blueprint $table) {
        $table->id();
        $table->bigInteger('participante_id')->unsigned(); // Cambiado a bigInteger
        $table->bigInteger('curso_id')->unsigned(); // Cambiado a bigInteger
        $table->date('FechadelCurso');
        $table->timestamps();

        // Definición de claves foráneas
        $table->foreign('participante_id')->references('id')->on('participantes')->onDelete('cascade');
        $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participante_curso');
    }
};
