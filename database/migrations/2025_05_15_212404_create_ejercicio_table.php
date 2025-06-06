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
        Schema::create('Ejercicio', function (Blueprint $table) {
            $table->increments('id_ejercicio');
            $table->string('nombre', 255)->nullable(false)->unique();
            $table->text('descripcion')->nullable();
            $table->text('instrucciones')->nullable(); // <-- AÑADIDA
            // $table->string('video_url', 500)->nullable(); // Opcional
            $table->timestamps(); // Para created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Ejercicio');
    }
};