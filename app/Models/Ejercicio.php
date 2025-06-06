<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ejercicio extends Model
{
    use HasFactory;

    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'Ejercicio';

    /**
     * La clave primaria asociada con la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_ejercicio';

    /**
     * Indica si el modelo debe tener timestamps.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'instrucciones',
        // Si añadiste más campos a tu migración 'Ejercicio' y quieres que sean fillable,
        // como 'grupo_muscular_principal' o 'equipamiento_requerido', añádelos aquí.
        // Ejemplo:
        // 'grupo_muscular_principal',
        // 'equipamiento_requerido',
        // 'video_url',
        // 'id_entrenador_creador', // Si el ejercicio es creado por un entrenador específico
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // Aquí puedes definir conversiones de tipo si es necesario
        // Por ejemplo, si tuvieras un campo 'is_active' que es un booleano:
        // 'is_active' => 'boolean',
    ];

    /**
     * Define la relación muchos-a-muchos con el modelo Rutina.
     * Un ejercicio puede estar en muchas rutinas.
     */
    public function rutinas()
    {
        return $this->belongsToMany(
            Rutina::class,
            'Rutina_Ejercicio', // Nombre de la tabla pivote
            'id_ejercicio',     // Clave foránea en la tabla pivote para este modelo (Ejercicio)
            'id_rutina'         // Clave foránea en la tabla pivote para el modelo relacionado (Rutina)
        )
            ->using(RutinaEjercicio::class) // Especifica el modelo pivote personalizado si lo tienes
            ->withPivot(['orden', 'series', 'repeticiones', 'duracion', 'descanso', 'notas']) // Campos adicionales de la tabla pivote
            ->withTimestamps(); // Si la tabla pivote tiene sus propios timestamps (created_at, updated_at)
    }

    // Si decides que un ejercicio es creado por un entrenador y añadiste 'id_entrenador_creador'
    // podrías tener una relación como esta:
    // public function creador()
    // {
    //     return $this->belongsTo(Entrenador::class, 'id_entrenador_creador', 'id_entrenador');
    // }
}