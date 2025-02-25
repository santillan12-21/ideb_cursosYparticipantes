<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameCourseDeletionLogsToCourseActionLogs extends Migration
{
    public function up()
    {
        // Renombrar la tabla
        Schema::rename('course_deletion_logs', 'course_action_logs');

        // Agregar columnas adicionales para soportar más acciones
        Schema::table('course_action_logs', function (Blueprint $table) {
            $table->string('accion')->change(); // Permitir más acciones (crear, editar, eliminar)
            $table->text('detalles')->nullable(); // Detalles adicionales sobre la acción
        });
    }

    public function down()
    {
        // Revertir cambios
        Schema::table('course_action_logs', function (Blueprint $table) {
            $table->dropColumn('detalles');
        });

        Schema::rename('course_action_logs', 'course_deletion_logs');
    }
}
