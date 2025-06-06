@extends('layouts.admin')

@section('title', 'Gestionar Clases Grupales')

@section('page-title', 'Gestión de Clases Grupales')

@section('content')
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
        <a href="{{ route('admin.group_classes.create') }}" class="btn btn-primary">Añadir Nueva Clase Grupal</a>
    </div>

    @if(isset($groupClasses) && !$groupClasses->isEmpty())
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Hora Inicio</th>
                    <th>Hora Fin</th>
                    <th>Cupo Máx.</th>
                    <th>Entrenador</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groupClasses as $class)
                    <tr>
                        <td>{{ $class->id_clase }}</td>
                        <td>{{ $class->nombre }}</td>
                        <td>{{ Str::limit($class->descripcion, 70) }}</td>
                        <td>{{ $class->fecha->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($class->hora_inicio)->format('h:i A') }}</td>
                        <td>{{ $class->hora_fin ? \Carbon\Carbon::parse($class->hora_fin)->format('h:i A') : 'N/A' }}</td>
                        <td>{{ $class->cupo_maximo }}</td>
                        <td>{{ $class->entrenador->nombre ?? 'No asignado' }}</td>
                        <td>{{ ucfirst($class->estado) }}</td>
                        <td>
                            <a href="{{ route('admin.group_classes.show', $class->id_clase) }}"
                                class="btn btn-sm btn-info">Detalles/Inscritos</a>
                            <a href="{{ route('admin.group_classes.edit', $class->id_clase) }}"
                                class="btn btn-sm btn-warning">Editar</a>
                            <form action="{{ route('admin.group_classes.destroy', $class->id_clase) }}" method="POST"
                                style="display:inline;"
                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta clase grupal? Esta acción no se puede deshacer.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            {{ $groupClasses->links() }}
        </div>
    @else
        <p>No hay clases grupales programadas por el momento.</p>
    @endif
@endsection