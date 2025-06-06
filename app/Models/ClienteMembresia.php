<?php

namespace App\Models; // Asegúrate de que el namespace sea el correcto

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; // Usamos Model base, no Authenticatable

class ClienteMembresia extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'Cliente_Membresia';

    /**
     * La clave primaria asociada con la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_cliente_membresia';

    /**
     * Indica si el modelo debe tener timestamps.
     * Tu migración para Cliente_Membresia incluye $table->timestamps();
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
        'id_cliente',
        'id_tipo_membresia',
        'fecha_inicio',
        'fecha_fin',
        'estado',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_inicio' => 'date', // O 'datetime' si incluye hora
        'fecha_fin' => 'date',    // O 'datetime' si incluye hora
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones Eloquent
    |--------------------------------------------------------------------------
    */

    /**
     * Obtiene el cliente al que pertenece esta instancia de membresía.
     * Esta instancia de membresía tiene una columna 'id_cliente'.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    /**
     * Obtiene el tipo de membresía asociado con esta instancia.
     * Esta instancia de membresía tiene una columna 'id_tipo_membresia'.
     */
    public function tipoMembresia()
    {
        return $this->belongsTo(TipoMembresia::class, 'id_tipo_membresia', 'id_tipo_membresia');
    }

    /**
     * Obtiene los pagos asociados a esta instancia de membresía.
     * La tabla 'Pago' tiene una columna 'id_cliente_membresia'.
     * Si solo puede haber UN pago por ClienteMembresia, usarías hasOne.
     * Si puede haber VARIOS pagos (ej. cuotas), usas hasMany.
     * Basado en el MER (id_pago como PK en Pago y FK id_cliente_membresia),
     * parece más una relación donde una ClienteMembresia tiene varios pagos,
     * o un pago pertenece a una ClienteMembresia. Si es UN solo pago por membresía (ClienteMembresia),
     * y Pago es el registro de ESE pago, entonces una ClienteMembresia PODRÍA tener un pago.
     *
     * Si un pago es único para una cliente_membresia, sería hasOne:
     * public function pago() {
     * return $this->hasOne(Pago::class, 'id_cliente_membresia', 'id_cliente_membresia');
     * }
     *
     * Si una cliente_membresia puede tener varios registros de pago (ej. si se paga en cuotas y cada cuota es un registro en Pago):
     * public function pagos() {
     * return $this->hasMany(Pago::class, 'id_cliente_membresia', 'id_cliente_membresia');
     * }
     * Dado que la tabla Pago tiene su propio id_pago como PK, es más probable que sea hasMany.
     */
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_cliente_membresia', 'id_cliente_membresia');
    }
}