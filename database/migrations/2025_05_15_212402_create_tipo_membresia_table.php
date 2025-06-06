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
        Schema::create('Tipo_Membresia', function (Blueprint $table) { // Nombre exacto de la tabla
            $table->increments('id_tipo_membresia'); // PK INT UNSIGNED AUTO_INCREMENT

            $table->string('nombre', 100)->nullable(false)->unique(); // VARCHAR(100) NOT NULL UNIQUE
            $table->text('descripcion')->nullable(); // TEXT NULL
            $table->unsignedInteger('duracion_dias')->nullable(false); // INT UNSIGNED NOT NULL
            $table->decimal('precio', 10, 2)->nullable(false); // DECIMAL(10, 2) NOT NULL
            $table->string('estado', 10)->nullable(false)->default('activo'); // VARCHAR(10) NOT NULL

            // Si necesitas timestamps automáticos created_at y updated_at
            $table->timestamps();

            // CHECK constraints ELIMINADOS (se validan en app)
            // $table->check('duracion_dias > 0');
            // $table->check('precio >= 0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Tipo_Membresia'); // Nombre exacto de la tabla
    }
};