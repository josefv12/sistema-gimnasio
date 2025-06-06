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
        Schema::create('Pago', function (Blueprint $table) { // Nombre exacto de la tabla
            $table->increments('id_pago'); // PK INT UNSIGNED AUTO_INCREMENT

            // FK a Cliente_Membresia (INT UNSIGNED NOT NULL)
            $table->unsignedInteger('id_cliente_membresia')->nullable(false);

            // DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            $table->dateTime('fecha_pago')->nullable(false)->useCurrent();
            $table->decimal('monto', 10, 2)->nullable(false); // DECIMAL(10, 2) NOT NULL
            $table->string('metodo_pago', 50)->nullable(false)->default('efectivo'); // VARCHAR(50) NOT NULL
            $table->string('estado', 15)->nullable(false)->default('completado'); // VARCHAR(15) NOT NULL

            // Columna opcional referencia_externa fue eliminada en la versión simplificada, si la quieres de vuelta, añádela:
            // $table->string('referencia_externa', 255)->nullable();

            // Si necesitas timestamps automáticos created_at y updated_at
            $table->timestamps();

            // Definición de la restricción FOREIGN KEY y ON DELETE
            $table->foreign('id_cliente_membresia')
                ->references('id_cliente_membresia')->on('Cliente_Membresia')
                ->onDelete('restrict'); // ON DELETE RESTRICT

            // CHECK constraint simple ELIMINADO
            // $table->check('monto >= 0');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Pago'); // Nombre exacto de la tabla
    }
};