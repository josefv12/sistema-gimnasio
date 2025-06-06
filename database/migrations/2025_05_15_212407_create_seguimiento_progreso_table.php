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
        Schema::create('Seguimiento_Progreso', function (Blueprint $table) { // Nombre exacto de la tabla
            $table->increments('id_seguimiento'); // PK INT UNSIGNED AUTO_INCREMENT

            // FK al Cliente (INT UNSIGNED NOT NULL)
            $table->unsignedInteger('id_cliente')->nullable(false);

            // DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            $table->dateTime('fecha')->nullable(false)->useCurrent();

            $table->decimal('peso', 6, 2)->nullable(); // DECIMAL(6, 2) NULL
            $table->text('medidas')->nullable(); // TEXT NULL
            $table->text('rendimiento_notas')->nullable(); // TEXT NULL

            // FK opcional a Asignacion_Rutina_Cliente (INT UNSIGNED NULL)
            $table->unsignedInteger('id_asignacion')->nullable();

            // Si necesitas timestamps automáticos created_at y updated_at
            $table->timestamps();

            // Definición de las restricciones FOREIGN KEY y ON DELETE
            $table->foreign('id_cliente')
                ->references('id_cliente')->on('Cliente') // Referencia a la tabla Cliente
                ->onDelete('cascade'); // ON DELETE CASCADE

            $table->foreign('id_asignacion')
                ->references('id_asignacion')->on('Asignacion_Rutina_Cliente') // Referencia a la tabla Asignacion_Rutina_Cliente
                ->onDelete('set null'); // ON DELETE SET NULL
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Seguimiento_Progreso'); // Nombre exacto de la tabla
    }
};