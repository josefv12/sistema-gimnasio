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
        Schema::create('Asignacion_Rutina_Cliente', function (Blueprint $table) { // Nombre exacto de la tabla
            $table->increments('id_asignacion'); // PK INT UNSIGNED AUTO_INCREMENT

            // FK al Cliente (INT UNSIGNED NOT NULL)
            $table->unsignedInteger('id_cliente')->nullable(false);
            // FK a Rutina (INT UNSIGNED NOT NULL)
            $table->unsignedInteger('id_rutina')->nullable(false);
            // FK al Entrenador (INT UNSIGNED NULL debido a ON DELETE SET NULL)
            $table->unsignedInteger('id_entrenador')->nullable();

            // DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            $table->dateTime('fecha_asignacion')->nullable(false)->useCurrent();

            // fecha_inicio_uso, fecha_fin_uso fueron eliminados en la versión simplificada. Si los quieres de vuelta:
            // $table->date('fecha_inicio_uso')->nullable();
            // $table->date('fecha_fin_uso')->nullable();

            $table->string('estado', 20)->nullable(false)->default('activa'); // VARCHAR(20) NOT NULL
            $table->text('notas_entrenador')->nullable(); // TEXT NULL

            // Si necesitas timestamps automáticos created_at y updated_at
            $table->timestamps();


            // Definición de las restricciones FOREIGN KEY y ON DELETE
            $table->foreign('id_cliente')
                ->references('id_cliente')->on('Cliente') // Referencia a la tabla Cliente
                ->onDelete('cascade'); // ON DELETE CASCADE

            $table->foreign('id_rutina')
                ->references('id_rutina')->on('Rutina') // Referencia a la tabla Rutina
                ->onDelete('restrict'); // ON DELETE RESTRICT

            $table->foreign('id_entrenador')
                ->references('id_entrenador')->on('Entrenador') // Referencia a la tabla Entrenador
                ->onDelete('set null'); // ON DELETE SET NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Asignacion_Rutina_Cliente'); // Nombre exacto de la tabla
    }
};