<?php

namespace App\Models; // Asegúrate de que el namespace coincida con la ubicación de tu archivo

// Traits y Clases Base
use Illuminate\Foundation\Auth\User as Authenticatable; // Para la autenticación
use Illuminate\Database\Eloquent\Factories\HasFactory;   // Para usar factories
use Illuminate\Notifications\Notifiable;                // Para el sistema de notificaciones de Laravel
use Spatie\Permission\Traits\HasRoles;                  // Para Spatie/laravel-permission

class Cliente extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles; // Traits que utilizará el modelo

    /**
     * El nombre de la tabla asociada con el modelo.
     */
    protected $table = 'Cliente';

    /**
     * La clave primaria asociada con la tabla.
     */
    protected $primaryKey = 'id_cliente';

    /**
     * Indica si el modelo debe tener timestamps (created_at y updated_at).
     */
    public $timestamps = true;

    /**
     * Los atributos que son asignables masivamente.
     */
    protected $fillable = [
        'nombre',
        'edad',
        'genero',
        'correo',
        'password',
        'telefono',
        // 'fecha_registro', // Eliminado, asumiendo que created_at (de timestamps()) es suficiente
    ];

    /**
     * Los atributos que deben ocultarse para las serializaciones.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     */
    protected $casts = [
        'password' => 'hashed',
        'edad' => 'integer',
        // 'fecha_registro' => 'datetime', // Si hubieras mantenido la columna fecha_registro
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones Eloquent
    |--------------------------------------------------------------------------
    */

    /**
     * Obtiene las membresías (activas o históricas) asociadas a este cliente.
     */
    public function clienteMembresias()
    {
        return $this->hasMany(ClienteMembresia::class, 'id_cliente', 'id_cliente');
    }

    /**
     * Obtiene los registros de asistencia de este cliente.
     */
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'id_cliente', 'id_cliente');
    }

    /**
     * Obtiene las reservas de clases grupales (registros de la tabla pivote) realizadas por este cliente.
     * Esta relación te da acceso directo a los objetos ClienteClaseReserva.
     */
    public function clienteClaseReservas() // Nombre anterior, mantenido para diferenciar
    {
        return $this->hasMany(ClienteClaseReserva::class, 'id_cliente', 'id_cliente');
    }

    /**
     * Obtiene las rutinas que han sido asignadas a este cliente.
     */
    public function asignacionesRutina()
    {
        return $this->hasMany(AsignacionRutinaCliente::class, 'id_cliente', 'id_cliente');
    }

    /**
     * Obtiene los registros de seguimiento de progreso para este cliente.
     */
    public function seguimientosProgreso()
    {
        return $this->hasMany(SeguimientoProgreso::class, 'id_cliente', 'id_cliente');
    }

    /**
     * Obtiene los pagos del cliente a través de sus membresías.
     */
    public function pagos()
    {
        return $this->hasManyThrough(
            Pago::class,
            ClienteMembresia::class,
            'id_cliente',
            'id_cliente_membresia',
            'id_cliente',
            'id_cliente_membresia'
        );
    }

    /**
     * Obtiene las clases grupales a las que este cliente ha realizado una reserva.
     * Esta es la relación muchos-a-muchos que utiliza el modelo pivote ClienteClaseReserva.
     */
    public function clasesGrupalesReservadas() // <-- ESTA ES LA RELACIÓN AÑADIDA/ACTUALIZADA
    {
        return $this->belongsToMany(
            ClaseGrupal::class,             // Modelo final al que queremos llegar
            'Cliente_Clase_Reserva',        // Nombre de la tabla pivote
            'id_cliente',                   // Clave foránea en la tabla pivote para este modelo (Cliente)
            'id_clase'                      // Clave foránea en la tabla pivote para el modelo relacionado (ClaseGrupal)
        )
            ->using(ClienteClaseReserva::class) // Especifica que se debe usar el modelo ClienteClaseReserva para la tabla pivote
            ->withPivot(['id_cliente_clase', 'fecha_reserva', 'estado', 'fecha_hora_registro_asistencia']) // Campos de la tabla pivote que queremos acceder
            ->withTimestamps(); // Si la tabla pivote Cliente_Clase_Reserva tiene sus propios timestamps (created_at, updated_at)
    }
}