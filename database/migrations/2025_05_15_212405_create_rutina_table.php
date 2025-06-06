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
        Schema::create('Rutina', function (Blueprint $table) { // Nombre exacto de la tabla
            $table->increments('id_rutina'); // PK INT UNSIGNED AUTO_INCREMENT

            $table->string('nombre', 150)->nullable(false); // VARCHAR(150) NOT NULL

            // objetivo y nivel fueron eliminados en la versión simplificada, si los quieres de vuelta:
            // $table->string('objetivo', 255)->nullable();
            // $table->string('nivel', 50)->nullable();

            // FK al Entrenador (INT UNSIGNED NULL debido a ON DELETE SET NULL)
            $table->unsignedInteger('id_entrenador')->nullable();

            // Si necesitas timestamps automáticos created_at y updated_at
            $table->timestamps();

            // Definición de la restricción FOREIGN KEY y ON DELETE
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
        Schema::dropIfExists('Rutina'); // Nombre exacto de la tabla
    }
};