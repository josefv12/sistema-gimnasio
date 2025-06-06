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
        Schema::create('Asistencia', function (Blueprint $table) { // Nombre exacto de la tabla
            $table->increments('id_asistencia'); // PK INT UNSIGNED AUTO_INCREMENT

            // FK al Cliente (INT UNSIGNED NOT NULL)
            $table->unsignedInteger('id_cliente')->nullable(false);

            // DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
            $table->dateTime('hora_entrada')->nullable(false)->useCurrent();
            // DATETIME NULL
            $table->dateTime('hora_salida')->nullable();

            $table->string('tipo_registro', 20)->nullable(false)->default('gym'); // VARCHAR(20) NOT NULL
            // FK opcional a Clase_Grupal (INT UNSIGNED NULL)
            $table->unsignedInteger('id_clase')->nullable(); // Asegúrate de que sea nullable si es opcional

            // Si necesitas timestamps automáticos created_at y updated_at
            $table->timestamps();

            // Definición de las restricciones FOREIGN KEY y ON DELETE
            $table->foreign('id_cliente')
                ->references('id_cliente')->on('Cliente') // Referencia a la tabla Cliente
                ->onDelete('cascade'); // ON DELETE CASCADE

            // Nota: La FK a Clase_Grupal es opcional en tu SQL, y tiene ON DELETE SET NULL
            // $table->unsignedInteger('id_clase')->nullable(); // <- Columna ya definida arriba
            $table->foreign('id_clase')
                ->references('id_clase')->on('Clase_Grupal') // Referencia a la tabla Clase_Grupal
                ->onDelete('set null'); // ON DELETE SET NULL

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Asistencia'); // Nombre exacto de la tabla
    }
};