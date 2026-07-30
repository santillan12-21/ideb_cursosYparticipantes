<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->date('fecha_imparticion_inicio')->nullable()->after('fecha_termino');
            $table->date('fecha_imparticion_termino')->nullable()->after('fecha_imparticion_inicio');
        });
    }

    public function down(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropColumn(['fecha_imparticion_inicio', 'fecha_imparticion_termino']);
        });
    }
};
