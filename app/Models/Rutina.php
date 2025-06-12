<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rutina extends Model
{
    use HasFactory;

    // Asumiendo que tu tabla se llama 'Rutina' y la PK es 'id_rutina'
    protected $table = 'Rutina';
    protected $primaryKey = 'id_rutina';

    // Atributos que se pueden asignar masivamente
    protected $fillable = [
        'nombre',
        'descripcion',
        'id_entrenador',
        // 'nivel_dificultad', // etc.
    ];

    // ===== INICIO DE LA MODIFICACIÓN =====
    // Se añade esta propiedad para asegurar que Laravel maneje created_at y updated_at
    public $timestamps = true;
    // ===== FIN DE LA MODIFICACIÓN =====


    /*
    |--------------------------------------------------------------------------
    | Relaciones Eloquent
    |--------------------------------------------------------------------------
    */

    /**
     * Obtiene el entrenador que creó esta rutina.
     */
    public function entrenador()
    {
        return $this->belongsTo(Entrenador::class, 'id_entrenador', 'id_entrenador');
    }

    // ===== INICIO DE LA MODIFICACIÓN =====
    /**
     * Obtiene los registros de la tabla pivote Rutina_Ejercicio asociados a esta rutina.
     */
    public function rutinaEjercicios()
    {
        // Una Rutina TIENE MUCHOS registros de RutinaEjercicio.
        return $this->hasMany(RutinaEjercicio::class, 'id_rutina', 'id_rutina');
    }
    // ===== FIN DE LA MODIFICACIÓN =====

    /**
     * Obtiene los ejercicios asociados a esta rutina a través de la tabla pivote.
     */
    public function ejercicios()
    {
        return $this->belongsToMany(
            Ejercicio::class,
            'Rutina_Ejercicio',
            'id_rutina',
            'id_ejercicio'
        )
            ->using(RutinaEjercicio::class)
            ->withPivot([
                'id_rutina_ejercicio',
                'orden',
                'series',
                'repeticiones',
                'duracion',
                'descanso',
                'notas'
            ])
            ->withTimestamps();
    }

    /**
     * Obtiene todas las veces que esta rutina ha sido asignada a clientes.
     */
    public function asignacionesAClientes()
    {
        return $this->hasMany(AsignacionRutinaCliente::class, 'id_rutina', 'id_rutina');
    }
}