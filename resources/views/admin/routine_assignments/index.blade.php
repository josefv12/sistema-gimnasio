@extends('layouts.admin')

@section('title', 'Gestionar Asignaciones de Rutinas')

@section('page-title', 'Gestión de Asignaciones de Rutinas a Clientes')

@section('content')
    {{-- Mostrar mensajes de sesión --}}
    @if (session('success'))
        <div class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger mb-3">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.routine_assignments.create') }}" class="btn btn-primary">Asignar Nueva Rutina</a>
    </div>

    @if(isset($assignments) && !$assignments->isEmpty())
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Rutina</th>
                    <th>Entrenador Asignó</th>
                    <th>Fecha Asignación</th>
                    <th>Estado</th>
                    <th>Notas</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assignments as $assignment)
                    <tr>
                        <td>{{ $assignment->id_asignacion }}</td>
                        <td>{{ $assignment->cliente->nombre ?? 'N/A' }}</td>
                        <td>{{ $assignment->rutina->nombre ?? 'N/A' }}</td>
                        <td>{{ $assignment->entrenador->nombre ?? 'N/A o Sistema' }}</td>
                        <td>{{ $assignment->fecha_asignacion->format('d/m/Y H:i') }}</td>
                        <td>{{ ucfirst($assignment->estado) }}</td>
                        <td>{{ Str::limit($assignment->notas_entrenador, 50) ?? 'N/A' }}</td>
                        <td>
                            <a href="{{ route('admin.routine_assignments.edit', $assignment->id_asignacion) }}"
                                class="btn btn-sm btn-warning">Editar</a>
                            {{-- Formulario para Eliminar (AHORA ACTIVO) --}}
                            <form action="{{ route('admin.routine_assignments.destroy', $assignment->id_asignacion) }}"
                                method="POST" style="display:inline;"
                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta asignación de rutina?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{-- Mostrar enlaces de paginación --}}
        <div class="mt-3">
            {{ $assignments->links() }}
        </div>
    @else
        <p>No hay asignaciones de rutinas registradas por el momento.</p>
    @endif
@endsection