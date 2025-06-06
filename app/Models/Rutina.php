<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rutina extends Model
{
    use HasFactory;

    protected $table = 'Rutina';
    protected $primaryKey = 'id_rutina';
    public $timestamps = true;

    protected $fillable = [
        'nombre',
        'id_entrenador',
        // NO incluyas 'descripcion', 'objetivo', 'nivel' aquí si no están en la tabla
    ];

    public function entrenadorCreador()
    {
        return $this->belongsTo(Entrenador::class, 'id_entrenador', 'id_entrenador');
    }

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
                'id_rutina_ejercicio', // <-- AÑADIDO AQUÍ
                'orden',
                'series',
                'repeticiones',
                'duracion',
                'descanso',
                'notas'
            ])
            ->withTimestamps();
    }

    public function asignacionesAClientes()
    {
        return $this->hasMany(AsignacionRutinaCliente::class, 'id_rutina', 'id_rutina');
    }
}