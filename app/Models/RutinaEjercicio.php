<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RutinaEjercicio extends Pivot
{
    protected $table = 'Rutina_Ejercicio';
    protected $primaryKey = 'id_rutina_ejercicio'; // PK de la tabla pivote
    public $incrementing = true; // Porque 'id_rutina_ejercicio' es autoincremental
    public $timestamps = true; // La tabla pivote tiene sus propios timestamps

    protected $fillable = [
        'id_rutina',
        'id_ejercicio',
        'orden',
        'series',
        'repeticiones',
        'duracion',
        'descanso',
        'notas',
    ];

    protected $casts = [
        'orden' => 'integer',
    ];

    public function rutina()
    {
        return $this->belongsTo(Rutina::class, 'id_rutina');
    }

    public function ejercicio()
    {
        return $this->belongsTo(Ejercicio::class, 'id_ejercicio');
    }
}