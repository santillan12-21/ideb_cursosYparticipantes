<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('cursos', 'modalidad')) {
            Schema::table('cursos', function (Blueprint $table) {
                $table->string('modalidad', 20)->nullable()->after('fecha_termino');
            });
        }

        if (!Schema::hasTable('curso_modalidades')) {
            Schema::create('curso_modalidades', function (Blueprint $table) {
                $table->id();
                $table->foreignId('curso_id')->constrained('cursos')->cascadeOnDelete();
                $table->string('modalidad', 20);
                $table->unique(['curso_id', 'modalidad']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('curso_modalidades');

        if (Schema::hasColumn('cursos', 'modalidad')) {
            Schema::table('cursos', function (Blueprint $table) {
                $table->dropColumn('modalidad');
            });
        }
    }
};
