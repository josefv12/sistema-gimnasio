<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
// use Illuminate\Database\Eloquent\Factories\HasFactory; // Opcional

class ClienteClaseReserva extends Pivot
{
    // use HasFactory; // Opcional

    /**
     * El nombre de la tabla asociada con el modelo.
     * (Ajusta si tu tabla en la BD se llama 'cliente_clase_reserva' en minúsculas)
     */
    protected $table = 'Cliente_Clase_Reserva'; // Nombre según MER: sistema-gimnasio_cliente_clase_reserva

    /**
     * La clave primaria asociada con la tabla.
     * Tu MER y migración muestran 'id_cliente_clase' como PK.
     */
    protected $primaryKey = 'id_cliente_clase';

    /**
     * Indica si los IDs son autoincrementales.
     */
    public $incrementing = true;

    /**
     * Indica si el modelo debe tener timestamps (created_at y updated_at).
     * (Asumiendo que tu migración para Cliente_Clase_Reserva incluye $table->timestamps()).
     */
    public $timestamps = true;

    /**
     * Los atributos que son asignables masivamente.
     */
    protected $fillable = [
        'id_cliente',
        'id_clase',
        'fecha_reserva',
        'estado',
        'fecha_hora_registro_asistencia', // Campo del MER
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     */
    protected $casts = [
        'fecha_reserva' => 'datetime',
        'fecha_hora_registro_asistencia' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones Eloquent (Inversas desde el Pivote)
    |--------------------------------------------------------------------------
    */

    /**
     * Obtiene el cliente que realizó esta reserva.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    /**
     * Obtiene la clase grupal que fue reservada.
     */
    public function claseGrupal()
    {
        return $this->belongsTo(ClaseGrupal::class, 'id_clase', 'id_clase');
    }
}