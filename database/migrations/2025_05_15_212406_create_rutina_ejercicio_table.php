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
        Schema::create('Rutina_Ejercicio', function (Blueprint $table) {
            $table->increments('id_rutina_ejercicio'); // <-- PK AÑADIDA
            $table->unsignedInteger('id_rutina')->nullable(false);
            $table->unsignedInteger('id_ejercicio')->nullable(false);
            $table->unsignedInteger('orden')->default(1);
            $table->string('series', 20)->nullable();
            $table->string('repeticiones', 20)->nullable();
            $table->string('duracion', 50)->nullable();
            $table->string('descanso', 50)->nullable();
            $table->text('notas')->nullable();
            $table->timestamps(); // Para created_at y updated_at

            // Clave única para evitar duplicados del mismo ejercicio en el mismo orden dentro de una rutina
            $table->unique(['id_rutina', 'id_ejercicio', 'orden'], 'rutina_ejercicio_orden_unique');

            $table->foreign('id_rutina')
                ->references('id_rutina')->on('Rutina')
                ->onDelete('cascade');

            $table->foreign('id_ejercicio')
                ->references('id_ejercicio')->on('Ejercicio')
                ->onDelete('restrict'); // O 'cascade' si prefieres que se borren los detalles si se borra el ejercicio
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Rutina_Ejercicio');
    }
};