<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeguimientoProgreso extends Model
{
    use HasFactory;

    protected $table = 'Seguimiento_Progreso';
    protected $primaryKey = 'id_seguimiento';
    public $timestamps = true;

    protected $fillable = [
        'id_cliente',
        'fecha',
        'peso',
        'medidas',
        'rendimiento_notas',
        'id_asignacion', // Asegúrate que tu migración Asignacion_Rutina_Cliente use 'id_asignacion'
        // En tu migración de Seguimiento_Progreso es 'id_asignacion'
        // pero en la de Asignacion_Rutina_Cliente es 'id_asignacion' también, así que está bien.
    ];

    protected $casts = [
        'fecha' => 'datetime',
        'peso' => 'decimal:2',
    ];

    /**
     * Obtiene el cliente al que pertenece este seguimiento.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    /**
     * Obtiene la asignación de rutina asociada con este seguimiento (opcional).
     */
    public function asignacionRutinaCliente()
    {
        // El nombre de la clave foránea en esta tabla es 'id_asignacion'
        // y en la tabla Asignacion_Rutina_Cliente la clave primaria es 'id_asignacion'
        return $this->belongsTo(AsignacionRutinaCliente::class, 'id_asignacion', 'id_asignacion');
    }

    // Si en el futuro añades 'id_entrenador_registra'
    // public function entrenadorRegistra()
    // {
    //     return $this->belongsTo(Entrenador::class, 'id_entrenador_registra', 'id_entrenador');
    // }
}