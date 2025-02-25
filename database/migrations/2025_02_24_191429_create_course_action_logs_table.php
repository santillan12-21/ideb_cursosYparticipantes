<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseActionLogsTable extends Migration
{
    public function up()
    {
        Schema::create('course_action_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('curso_id')->nullable(); // ID del curso relacionado (puede ser nulo si el curso fue eliminado permanentemente)
            $table->string('nombre_curso'); // Nombre del curso
            $table->unsignedBigInteger('user_id'); // ID del usuario que realizó la acción
            $table->string('accion'); // Acción realizada ("Creado", "Editado", "Eliminado", etc.)
            $table->text('detalles')->nullable(); // Detalles adicionales sobre la acción
            $table->timestamp('fecha_accion')->nullable(); // Fecha y hora de la acción
            $table->timestamps();

            // Claves foráneas
            $table->foreign('curso_id')->references('id')->on('cursos')->onDelete('set null'); // Relación con la tabla cursos
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); // Relación con la tabla users
        });
    }

    public function down()
    {
        Schema::dropIfExists('course_action_logs');
    }
}
