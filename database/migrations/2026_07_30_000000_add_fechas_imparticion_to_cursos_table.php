<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('cursos', 'fecha_imparticion_inicio')) {
            Schema::table('cursos', function (Blueprint $table) {
                $table->date('fecha_imparticion_inicio')->nullable()->after('fecha_termino');
            });
        }

        if (!Schema::hasColumn('cursos', 'fecha_imparticion_termino')) {
            Schema::table('cursos', function (Blueprint $table) {
                $after = Schema::hasColumn('cursos', 'fecha_imparticion_inicio')
                    ? 'fecha_imparticion_inicio'
                    : 'fecha_termino';
                $table->date('fecha_imparticion_termino')->nullable()->after($after);
            });
        }
    }

    public function down(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $columns = array_filter([
                Schema::hasColumn('cursos', 'fecha_imparticion_inicio') ? 'fecha_imparticion_inicio' : null,
                Schema::hasColumn('cursos', 'fecha_imparticion_termino') ? 'fecha_imparticion_termino' : null,
            ]);

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};
