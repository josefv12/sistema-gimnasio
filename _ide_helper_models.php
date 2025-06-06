<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id_admin
 * @property string $nombre
 * @property string $correo
 * @property string $password
 * @property string|null $telefono
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrador newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrador newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrador permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrador query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrador role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrador whereCorreo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrador whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrador whereIdAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrador whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrador wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrador whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrador whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrador withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrador withoutRole($roles, $guard = null)
 */
	class Administrador extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionRutinaCliente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionRutinaCliente newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AsignacionRutinaCliente query()
 */
	class AsignacionRutinaCliente extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id_asistencia
 * @property int $id_cliente
 * @property \Illuminate\Support\Carbon $hora_entrada
 * @property \Illuminate\Support\Carbon|null $hora_salida
 * @property string $tipo_registro
 * @property int|null $id_clase
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ClaseGrupal|null $claseGrupal
 * @property-read \App\Models\Cliente $cliente
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia whereHoraEntrada($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia whereHoraSalida($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia whereIdAsistencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia whereIdClase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia whereIdCliente($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia whereTipoRegistro($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asistencia whereUpdatedAt($value)
 */
	class Asistencia extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id_clase
 * @property string $nombre
 * @property string|null $descripcion
 * @property \Illuminate\Support\Carbon $fecha
 * @property string $hora_inicio
 * @property string|null $hora_fin
 * @property int $cupo_maximo
 * @property int|null $id_entrenador
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Asistencia> $asistenciasDeClase
 * @property-read int|null $asistencias_de_clase_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ClienteClaseReserva> $clienteClaseReservas
 * @property-read int|null $cliente_clase_reservas_count
 * @property-read \App\Models\ClienteClaseReserva|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Cliente> $clientesReservados
 * @property-read int|null $clientes_reservados_count
 * @property-read \App\Models\Entrenador|null $entrenador
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClaseGrupal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClaseGrupal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClaseGrupal query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClaseGrupal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClaseGrupal whereCupoMaximo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClaseGrupal whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClaseGrupal whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClaseGrupal whereFecha($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClaseGrupal whereHoraFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClaseGrupal whereHoraInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClaseGrupal whereIdClase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClaseGrupal whereIdEntrenador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClaseGrupal whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClaseGrupal whereUpdatedAt($value)
 */
	class ClaseGrupal extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id_cliente
 * @property string $nombre
 * @property int|null $edad
 * @property string|null $genero
 * @property string $correo
 * @property string $password
 * @property string|null $telefono
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AsignacionRutinaCliente> $asignacionesRutina
 * @property-read int|null $asignaciones_rutina_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Asistencia> $asistencias
 * @property-read int|null $asistencias_count
 * @property-read \App\Models\ClienteClaseReserva|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ClaseGrupal> $clasesGrupalesReservadas
 * @property-read int|null $clases_grupales_reservadas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ClienteClaseReserva> $clienteClaseReservas
 * @property-read int|null $cliente_clase_reservas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ClienteMembresia> $clienteMembresias
 * @property-read int|null $cliente_membresias_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pago> $pagos
 * @property-read int|null $pagos_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SeguimientoProgreso> $seguimientosProgreso
 * @property-read int|null $seguimientos_progreso_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente whereCorreo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente whereEdad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente whereGenero($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente whereIdCliente($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Cliente withoutRole($roles, $guard = null)
 */
	class Cliente extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id_cliente_clase
 * @property int $id_cliente
 * @property int $id_clase
 * @property \Illuminate\Support\Carbon $fecha_reserva
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $fecha_hora_registro_asistencia
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ClaseGrupal $claseGrupal
 * @property-read \App\Models\Cliente $cliente
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteClaseReserva newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteClaseReserva newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteClaseReserva query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteClaseReserva whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteClaseReserva whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteClaseReserva whereFechaHoraRegistroAsistencia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteClaseReserva whereFechaReserva($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteClaseReserva whereIdClase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteClaseReserva whereIdCliente($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteClaseReserva whereIdClienteClase($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteClaseReserva whereUpdatedAt($value)
 */
	class ClienteClaseReserva extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id_cliente_membresia
 * @property int $id_cliente
 * @property int $id_tipo_membresia
 * @property \Illuminate\Support\Carbon $fecha_inicio
 * @property \Illuminate\Support\Carbon $fecha_fin
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Cliente $cliente
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pago> $pagos
 * @property-read int|null $pagos_count
 * @property-read \App\Models\TipoMembresia $tipoMembresia
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteMembresia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteMembresia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteMembresia query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteMembresia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteMembresia whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteMembresia whereFechaFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteMembresia whereFechaInicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteMembresia whereIdCliente($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteMembresia whereIdClienteMembresia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteMembresia whereIdTipoMembresia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ClienteMembresia whereUpdatedAt($value)
 */
	class ClienteMembresia extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id_ejercicio
 * @property string $nombre
 * @property string|null $descripcion
 * @property string|null $instrucciones
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\RutinaEjercicio|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rutina> $rutinas
 * @property-read int|null $rutinas_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ejercicio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ejercicio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ejercicio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ejercicio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ejercicio whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ejercicio whereIdEjercicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ejercicio whereInstrucciones($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ejercicio whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ejercicio whereUpdatedAt($value)
 */
	class Ejercicio extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id_entrenador
 * @property string $nombre
 * @property string|null $especialidad
 * @property string $correo
 * @property string $password
 * @property string|null $telefono
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AsignacionRutinaCliente> $asignacionesRutinaRealizadas
 * @property-read int|null $asignaciones_rutina_realizadas_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ClaseGrupal> $clasesGrupales
 * @property-read int|null $clases_grupales_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Rutina> $rutinasCreadas
 * @property-read int|null $rutinas_creadas_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador whereCorreo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador whereEspecialidad($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador whereIdEntrenador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador whereTelefono($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Entrenador withoutRole($roles, $guard = null)
 */
	class Entrenador extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id_pago
 * @property int $id_cliente_membresia
 * @property \Illuminate\Support\Carbon $fecha_pago
 * @property numeric $monto
 * @property string $metodo_pago
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ClienteMembresia $clienteMembresia
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereFechaPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereIdClienteMembresia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereIdPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereMetodoPago($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereMonto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pago whereUpdatedAt($value)
 */
	class Pago extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id_rutina
 * @property string $nombre
 * @property int|null $id_entrenador
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AsignacionRutinaCliente> $asignacionesAClientes
 * @property-read int|null $asignaciones_a_clientes_count
 * @property-read \App\Models\RutinaEjercicio|null $pivot
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Ejercicio> $ejercicios
 * @property-read int|null $ejercicios_count
 * @property-read \App\Models\Entrenador|null $entrenadorCreador
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rutina newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rutina newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rutina query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rutina whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rutina whereIdEntrenador($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rutina whereIdRutina($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rutina whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Rutina whereUpdatedAt($value)
 */
	class Rutina extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id_rutina_ejercicio
 * @property int $id_rutina
 * @property int $id_ejercicio
 * @property int $orden
 * @property string|null $series
 * @property string|null $repeticiones
 * @property string|null $duracion
 * @property string|null $descanso
 * @property string|null $notas
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ejercicio $ejercicio
 * @property-read \App\Models\Rutina $rutina
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RutinaEjercicio newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RutinaEjercicio newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RutinaEjercicio query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RutinaEjercicio whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RutinaEjercicio whereDescanso($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RutinaEjercicio whereDuracion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RutinaEjercicio whereIdEjercicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RutinaEjercicio whereIdRutina($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RutinaEjercicio whereIdRutinaEjercicio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RutinaEjercicio whereNotas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RutinaEjercicio whereOrden($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RutinaEjercicio whereRepeticiones($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RutinaEjercicio whereSeries($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RutinaEjercicio whereUpdatedAt($value)
 */
	class RutinaEjercicio extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SeguimientoProgreso newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SeguimientoProgreso newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SeguimientoProgreso query()
 */
	class SeguimientoProgreso extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id_tipo_membresia
 * @property string $nombre
 * @property string|null $descripcion
 * @property int $duracion_dias
 * @property numeric $precio
 * @property string $estado
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ClienteMembresia> $clienteMembresias
 * @property-read int|null $cliente_membresias_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoMembresia newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoMembresia newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoMembresia query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoMembresia whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoMembresia whereDescripcion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoMembresia whereDuracionDias($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoMembresia whereEstado($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoMembresia whereIdTipoMembresia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoMembresia whereNombre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoMembresia wherePrecio($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TipoMembresia whereUpdatedAt($value)
 */
	class TipoMembresia extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

