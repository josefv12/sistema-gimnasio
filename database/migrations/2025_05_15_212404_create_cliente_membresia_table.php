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
        Schema::create('Cliente_Membresia', function (Blueprint $table) { // Nombre exacto de la tabla
            $table->increments('id_cliente_membresia'); // PK INT UNSIGNED AUTO_INCREMENT

            // FK al Cliente (INT UNSIGNED NOT NULL)
            $table->unsignedInteger('id_cliente')->nullable(false);
            // FK al Tipo_Membresia (INT UNSIGNED NOT NULL)
            $table->unsignedInteger('id_tipo_membresia')->nullable(false);

            $table->date('fecha_inicio')->nullable(false); // DATE NOT NULL
            $table->date('fecha_fin')->nullable(false); // DATE NOT NULL
            $table->string('estado', 15)->nullable(false)->default('activa'); // VARCHAR(15) NOT NULL

            // Si necesitas timestamps automáticos created_at y updated_at
            $table->timestamps();

            // Clave única compuesta (UNIQUE) - ¡Añadido nombre corto para evitar error de longitud!
            $table->unique(['id_cliente', 'id_tipo_membresia', 'fecha_inicio'], 'client_mem_unique');

            // Definición de las restricciones FOREIGN KEY y ON DELETE
            $table->foreign('id_cliente')
                ->references('id_cliente')->on('Cliente') // Referencia a la tabla Cliente, columna id_cliente
                ->onDelete('cascade'); // ON DELETE CASCADE

            $table->foreign('id_tipo_membresia')
                ->references('id_tipo_membresia')->on('Tipo_Membresia') // Referencia a la tabla Tipo_Membresia, columna id_tipo_membresia
                ->onDelete('restrict'); // ON DELETE RESTRICT
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Cliente_Membresia'); // Nombre exacto de la tabla
    }
};