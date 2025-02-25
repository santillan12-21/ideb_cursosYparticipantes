<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateParticipantActionLogsTable extends Migration
{
    public function up()
    {
        Schema::create('participant_action_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('participant_id')->nullable(); // ID del participante afectado
            $table->string('nombre_postulante')->nullable(); // Nombre del postulante
            $table->string('correo')->nullable(); // Correo del postulante
            $table->string('accion'); // Acción realizada (e.g., "Creado", "Editado", "Eliminado")
            $table->unsignedBigInteger('user_id')->nullable(); // ID del usuario que realizó la acción
            $table->text('detalles')->nullable(); // Detalles adicionales de la acción
            $table->timestamp('fecha_accion')->nullable(); // Fecha y hora de la acción
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('participant_action_logs');
    }
}
