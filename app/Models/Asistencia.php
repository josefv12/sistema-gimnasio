<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada con el modelo.
     * (Ajusta si tu tabla en la BD se llama 'asistencia' en minúsculas)
     */
    protected $table = 'Asistencia'; // Nombre según MER: sistema-gimnasio_asistencia

    /**
     * La clave primaria asociada con la tabla.
     */
    protected $primaryKey = 'id_asistencia';

    /**
     * Indica si el modelo debe tener timestamps.
     * (Asumiendo que tu migración para Asistencia incluye $table->timestamps()).
     */
    public $timestamps = true;

    /**
     * Los atributos que son asignables masivamente.
     */
    protected $fillable = [
        'id_cliente',
        'hora_entrada',
        'hora_salida',
        'tipo_registro', // Campo del MER
        'id_clase',      // Campo del MER, puede ser null
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     */
    protected $casts = [
        'hora_entrada' => 'datetime',
        'hora_salida' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones Eloquent
    |--------------------------------------------------------------------------
    */

    /**
     * Obtiene el cliente al que pertenece este registro de asistencia.
     * Esta asistencia tiene una columna 'id_cliente'.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    /**
     * Obtiene la clase grupal (opcional) a la que está asociada esta asistencia.
     * Esta asistencia tiene una columna 'id_clase' que puede ser null.
     */
    public function claseGrupal()
    {
        return $this->belongsTo(ClaseGrupal::class, 'id_clase', 'id_clase');
    }
}