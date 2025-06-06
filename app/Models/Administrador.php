<?php

namespace App\Models; // Asegúrate de que el namespace coincida con la ubicación de tu archivo

// Traits y Clases Base
use Illuminate\Foundation\Auth\User as Authenticatable; // Para la autenticación
use Illuminate\Database\Eloquent\Factories\HasFactory;   // Para usar factories
use Illuminate\Notifications\Notifiable;                // Para el sistema de notificaciones de Laravel
use Spatie\Permission\Traits\HasRoles;                  // Para Spatie/laravel-permission

class Administrador extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles; // Traits que utilizará el modelo

    /**
     * El nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'Administrador';

    /**
     * La clave primaria asociada con la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_admin';

    /**
     * Indica si el modelo debe tener timestamps (created_at y updated_at).
     * Por defecto es true si la tabla los tiene (y tu migración los añade con $table->timestamps()).
     *
     * @var bool
     */
    public $timestamps = true; // O puedes omitir esta línea, ya que es true por defecto.

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'correo',
        'password',
        'telefono',
    ];

    /**
     * Los atributos que deben ocultarse para las serializaciones (ej. al convertir a JSON).
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token', // Añadido para ocultar el token de "Recordarme"
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime', // Descomenta si llegas a añadir esta columna
        'password' => 'hashed', // Para auto-hasheo en Laravel 10+
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones Eloquent
    |--------------------------------------------------------------------------
    |
    | Aquí definirás las relaciones que este modelo tiene con otros modelos.
    | Por el momento, el modelo Administrador no tiene relaciones directas
    | evidentes en tu MER donde sea el "dueño" de la FK o una tabla pivote.
    |
    | Ejemplo: Si un Administrador pudiera crear varios 'TipoMembresia' y
    | la tabla 'Tipo_Membresia' tuviera una columna 'creado_por_admin_id':
    |
    | public function tiposMembresiaCreados()
    | {
    |     return $this->hasMany(TipoMembresia::class, 'creado_por_admin_id', 'id_admin');
    | }
    */
}