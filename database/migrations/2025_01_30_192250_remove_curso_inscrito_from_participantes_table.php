<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up()
    {
        Schema::table('participantes', function (Blueprint $table) {
            $table->dropColumn('CursoInscrito'); // Elimina el campo si existe
        });
    }

    public function down()
    {
        Schema::table('participantes', function (Blueprint $table) {
            $table->string('CursoInscrito')->nullable(); // Opcional: para revertir la migración
        });
    }
};
