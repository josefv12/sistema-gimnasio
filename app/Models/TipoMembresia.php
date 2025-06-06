<?php

namespace App\Models; // Asegúrate de que el namespace sea el correcto

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoMembresia extends Model
{
    use HasFactory;

    /**
     * El nombre de la tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'Tipo_Membresia';

    /**
     * La clave primaria asociada con la tabla.
     *
     * @var string
     */
    protected $primaryKey = 'id_tipo_membresia';

    /**
     * Indica si el modelo debe tener timestamps (created_at y updated_at).
     * Tu migración para Tipo_Membresia incluye $table->timestamps();
     *
     * @var bool
     */
    public $timestamps = true; // O puedes omitir esta línea, es true por defecto

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'duracion_dias',
        'precio',
        'estado',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'duracion_dias' => 'integer',
        'precio' => 'decimal:2', // Para asegurar que se maneje como decimal con 2 posiciones
    ];

    /*
    |--------------------------------------------------------------------------
    | Relaciones Eloquent
    |--------------------------------------------------------------------------
    */

    /**
     * Obtiene todas las instancias de membresías de clientes que son de este tipo.
     * La tabla 'Cliente_Membresia' tiene una columna 'id_tipo_membresia'.
     */
    public function clienteMembresias()
    {
        return $this->hasMany(ClienteMembresia::class, 'id_tipo_membresia', 'id_tipo_membresia');
    }
}