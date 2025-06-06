<?php

namespace App\Models; // Asegúrate de que el namespace sea el correcto

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'Pago';

    /**
     * La clave primaria asociada con la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_pago';

    /**
     * Indica si el modelo debe tener timestamps.
     * Tu migración para Pago incluye $table->timestamps();
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
        'id_cliente_membresia',
        'fecha_pago',
        'monto',
        'metodo_pago',
        'estado',
        // 'referencia_externa', // Si decidiste añadirla de nuevo en la migración
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'fecha_pago' => 'datetime',
        'monto' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones Eloquent
    |--------------------------------------------------------------------------
    */

    /**
     * Obtiene la instancia de membresía de cliente a la que pertenece este pago.
     * Este pago tiene una columna 'id_cliente_membresia'.
     */
    public function clienteMembresia()
    {
        return $this->belongsTo(ClienteMembresia::class, 'id_cliente_membresia', 'id_cliente_membresia');
    }
}