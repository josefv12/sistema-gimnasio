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
        Schema::create('Cliente', function (Blueprint $table) {
            $table->increments('id_cliente'); // Clave primaria INT UNSIGNED AUTO_INCREMENT

            $table->string('nombre', 150)->nullable(false);
            $table->integer('edad')->unsigned()->nullable();
            $table->string('genero', 50)->nullable();
            $table->string('correo', 255)->unique()->nullable(false);
            $table->string('password', 255)->nullable(false); // Para la contraseña hasheada
            $table->string('telefono', 30)->nullable();

            // La columna 'fecha_registro' es opcional si 'created_at' (de timestamps) es suficiente.
            // Si la necesitas por una razón de negocio específica, puedes descomentarla:
            // $table->dateTime('fecha_registro')->useCurrent()->comment('Fecha de inscripción formal del cliente');

            // Para la funcionalidad "Recordarme" en sesiones web
            $table->rememberToken();

            // Añade las columnas created_at y updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Cliente');
    }
};