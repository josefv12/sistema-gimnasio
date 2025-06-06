<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignacionRutinaCliente extends Model
{
    use HasFactory;

    protected $table = 'Asignacion_Rutina_Cliente'; // Coincide con tu migración
    protected $primaryKey = 'id_asignacion';   // Coincide con tu migración
    public $timestamps = true;                 // Coincide con tu migración

    protected $fillable = [
        'id_cliente',
        'id_rutina',
        'id_entrenador',
        'fecha_asignacion',
        'estado',
        'notas_entrenador',
    ];

    protected $casts = [
        'fecha_asignacion' => 'datetime',
    ];

    /**
     * Obtiene el cliente al que se asignó la rutina.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    /**
     * Obtiene la rutina (plantilla) que fue asignada.
     */
    public function rutina()
    {
        return $this->belongsTo(Rutina::class, 'id_rutina', 'id_rutina');
    }

    /**
     * Obtiene el entrenador que asignó la rutina (si aplica).
     */
    public function entrenador()
    {
        return $this->belongsTo(Entrenador::class, 'id_entrenador', 'id_entrenador');
    }
}