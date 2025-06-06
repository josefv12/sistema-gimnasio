<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('Cliente_Clase_Reserva', function (Blueprint $table) { // Nombre exacto de la tabla
            $table->increments('id_cliente_clase'); // PK INT UNSIGNED AUTO_INCREMENT

            // FK al Cliente (INT UNSIGNED NOT NULL)
            $table->unsignedInteger('id_cliente')->nullable(false);
            // FK a Clase_Grupal (INT UNSIGNED NOT NULL)
            $table->unsignedInteger('id_clase')->nullable(false);

            // DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            $table->dateTime('fecha_reserva')->nullable(false)->useCurrent();
            $table->string('estado', 20)->nullable(false)->default('reservado'); // VARCHAR(20) NOT NULL
            // Timestamp de asistencia (DATETIME NULL) - Eliminado DEFAULT para que se registre al marcar asistencia
            $table->dateTime('fecha_hora_registro_asistencia')->nullable();

            // Si necesitas timestamps automáticos created_at y updated_at
            $table->timestamps();

            // Clave única compuesta (UNIQUE) - ¡Añadido nombre corto para evitar error de longitud!
            $table->unique(['id_cliente', 'id_clase'], 'client_clase_unq'); // <--- Añadido nombre corto

            // Definición de las restricciones FOREIGN KEY y ON DELETE
            $table->foreign('id_cliente')
                ->references('id_cliente')->on('Cliente') // Referencia a la tabla Cliente
                ->onDelete('cascade'); // ON DELETE CASCADE

            $table->foreign('id_clase')
                ->references('id_clase')->on('Clase_Grupal') // Referencia a la tabla Clase_Grupal
                ->onDelete('cascade'); // ON DELETE CASCADE
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Cliente_Clase_Reserva'); // Nombre exacto de la tabla
    }
};