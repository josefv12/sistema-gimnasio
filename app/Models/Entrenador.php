<?php

namespace App\Models; // Asegúrate de que el namespace coincida con la ubicación de tu archivo

// Traits y Clases Base
use Illuminate\Foundation\Auth\User as Authenticatable; // Para la autenticación
use Illuminate\Database\Eloquent\Factories\HasFactory;   // Para usar factories
use Illuminate\Notifications\Notifiable;                // Para el sistema de notificaciones de Laravel
use Spatie\Permission\Traits\HasRoles;                  // Para Spatie/laravel-permission

class Entrenador extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles; // Traits que utilizará el modelo

    /**
     * El nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'Entrenador';

    /**
     * La clave primaria asociada con la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_entrenador';

    /**
     * Indica si el modelo debe tener timestamps (created_at y updated_at).
     *
     * @var bool
     */
    public $timestamps = true; // O puedes omitir esta línea, ya que es true por defecto

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'especialidad',
        'correo',
        'password',
        'telefono',
    ];

    /**
     * Los atributos que deben ocultarse para las serializaciones.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones Eloquent
    |--------------------------------------------------------------------------
    */

    /**
     * Obtiene las clases grupales que este entrenador imparte.
     * La tabla 'Clase_Grupal' tiene una columna 'id_entrenador'.
     */
    public function clasesGrupales()
    {
        return $this->hasMany(ClaseGrupal::class, 'id_entrenador', 'id_entrenador');
    }

    /**
     * Obtiene las rutinas (plantillas) creadas por este entrenador.
     * La tabla 'Rutina' tiene una columna 'id_entrenador'.
     */
    public function rutinasCreadas()
    {
        return $this->hasMany(Rutina::class, 'id_entrenador', 'id_entrenador');
    }

    /**
     * Obtiene las asignaciones de rutinas a clientes realizadas por este entrenador.
     * La tabla 'Asignacion_Rutina_Cliente' tiene una columna 'id_entrenador'.
     */
    public function asignacionesRutinaRealizadas()
    {
        return $this->hasMany(AsignacionRutinaCliente::class, 'id_entrenador', 'id_entrenador');
    }

    /**
     * Opcional: Si los entrenadores registran el progreso y se añade una FK a Seguimiento_Progreso.
     * Tu MER actual para Seguimiento_Progreso no incluye id_entrenador, pero tu documento
     * gimnasio.docx (Fuente 100) sí mencionaba un 'id_entrenador_registra'.
     * Si añades esa columna a la tabla y migración de Seguimiento_Progreso:
     *
     * public function seguimientosProgresoRegistrados()
     * {
     * return $this->hasMany(SeguimientoProgreso::class, 'id_entrenador_registra', 'id_entrenador');
     * }
     */
}