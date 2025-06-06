<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
// use Illuminate\Support\Facades\DB; // Ya no necesitas DB::statement si usas Schema::create

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Asegúrate de que esta definición de Schema::create contenga TODAS las columnas para Administrador
        Schema::create('Administrador', function (Blueprint $table) {
            $table->increments('id_admin'); // Clave primaria INT UNSIGNED AUTO_INCREMENT

            $table->string('nombre', 150)->nullable(false); // Columna 'nombre'
            $table->string('correo', 255)->unique()->nullable(false); // Columna 'correo' (única)
            $table->string('password', 255)->nullable(false); // Columna 'password' (contraseña hasheada)
            $table->string('telefono', 30)->nullable(); // Columna 'telefono' (opcional)

            $table->timestamps(); // Columnas created_at y updated_at (usadas por Eloquent por defecto)

            // Si usas la funcionalidad Remember Me
             $table->rememberToken(); // Columna remember_token
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Administrador');
    }
};

