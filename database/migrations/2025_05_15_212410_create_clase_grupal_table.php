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
        Schema::create('Clase_Grupal', function (Blueprint $table) { // Nombre exacto de la tabla
            $table->increments('id_clase'); // PK INT UNSIGNED AUTO_INCREMENT

            $table->string('nombre', 100)->nullable(false); // VARCHAR(100) NOT NULL
            $table->text('descripcion')->nullable(); // TEXT NULL
            $table->date('fecha')->nullable(false); // DATE NOT NULL
            $table->time('hora_inicio')->nullable(false); // TIME NOT NULL
            $table->time('hora_fin')->nullable(); // TIME NULL
            $table->unsignedInteger('cupo_maximo')->nullable(false); // INT UNSIGNED NOT NULL

            // FK al Entrenador (INT UNSIGNED NULL debido a ON DELETE SET NULL)
            $table->unsignedInteger('id_entrenador')->nullable();

            $table->string('estado', 20)->nullable(false)->default('programada'); // VARCHAR(20) NOT NULL

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
        Schema::dropIfExists('Clase_Grupal'); // Nombre exacto de la tabla
    }
};