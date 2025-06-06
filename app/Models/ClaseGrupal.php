<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaseGrupal extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada con el modelo.
     * (Ajusta si tu tabla en la BD se llama 'clase_grupal' en minúsculas)
     */
    protected $table = 'Clase_Grupal'; // Nombre según MER: sistema-gimnasio_clase_grupal

    /**
     * La clave primaria asociada con la tabla.
     */
    protected $primaryKey = 'id_clase';

    /**
     * Indica si el modelo debe tener timestamps (created_at y updated_at).
     * (Asumiendo que tu migración para Clase_Grupal incluye $table->timestamps()).
     */
    public $timestamps = true;

    /**
     * Los atributos que son asignables masivamente.
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha',
        'hora_inicio',
        'hora_fin', // Asegúrate que este campo exista en tu migración si lo quieres fillable
        'cupo_maximo',
        'id_entrenador',
        'estado',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     */
    protected $casts = [
        'fecha' => 'date',
        // 'hora_inicio' => 'datetime:H:i:s', // Laravel suele manejar 'time' bien, pero puedes ser explícito.
        // 'hora_fin' => 'datetime:H:i:s',    // O considera almacenar como datetime completo si es más fácil.
        'cupo_maximo' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones Eloquent
    |--------------------------------------------------------------------------
    */

    /**
     * Obtiene el entrenador que imparte esta clase grupal.
     * La tabla 'Clase_Grupal' tiene una columna 'id_entrenador'.
     */
    public function entrenador()
    {
        return $this->belongsTo(Entrenador::class, 'id_entrenador', 'id_entrenador');
    }

    /**
     * Obtiene todas las reservas de clientes para esta clase grupal (registros de la tabla pivote).
     * La tabla 'Cliente_Clase_Reserva' tiene una columna 'id_clase'.
     */
    public function clienteClaseReservas()
    {
        return $this->hasMany(ClienteClaseReserva::class, 'id_clase', 'id_clase');
    }

    /**
     * Obtiene todos los registros de asistencia para esta clase grupal.
     * La tabla 'Asistencia' tiene una columna 'id_clase'.
     */
    public function asistenciasDeClase() // Nombre más específico para esta relación
    {
        return $this->hasMany(Asistencia::class, 'id_clase', 'id_clase');
    }

    /**
     * Relación muchos-a-muchos para obtener los clientes que han reservado esta clase,
     * utilizando el modelo ClienteClaseReserva para la tabla pivote.
     */
    public function clientesReservados()
    {
        return $this->belongsToMany(
            Cliente::class,
            'Cliente_Clase_Reserva', // Nombre de la tabla pivote
            'id_clase',              // Clave foránea en la tabla pivote para este modelo (ClaseGrupal)
            'id_cliente'             // Clave foránea en la tabla pivote para el modelo relacionado (Cliente)
        )
            ->using(ClienteClaseReserva::class) // Especifica el modelo pivote que se usará
            ->withPivot(['id_cliente_clase', 'fecha_reserva', 'estado', 'fecha_hora_registro_asistencia']) // Campos de la tabla pivote
            ->withTimestamps(); // Si la tabla pivote Cliente_Clase_Reserva tiene sus propios timestamps
    }
}