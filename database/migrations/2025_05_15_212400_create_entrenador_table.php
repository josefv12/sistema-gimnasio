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
        Schema::create('Entrenador', function (Blueprint $table) { // Nombre exacto de la tabla
            $table->increments('id_entrenador'); // PK INT UNSIGNED AUTO_INCREMENT

            $table->string('nombre', 150)->nullable(false); // VARCHAR(150) NOT NULL
            $table->string('especialidad', 100)->nullable(); // VARCHAR(100) NULL
            $table->string('correo', 255)->unique()->nullable(false); // VARCHAR(255) NOT NULL UNIQUE
            $table->string('password', 255)->nullable(false); // VARCHAR(255) NOT NULL (contraseña hasheada)
            $table->string('telefono', 30)->nullable(); // VARCHAR(30) NULL

            // Si necesitas timestamps automáticos created_at y updated_at
            $table->timestamps(); // Crea 'created_at' y 'updated_at'

            // Si usas la funcionalidad Remember Me
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Entrenador'); // Nombre exacto de la tabla
    }
};