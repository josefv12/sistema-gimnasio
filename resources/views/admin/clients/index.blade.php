@extends('layouts.admin')

@section('title', 'Gestionar Clientes')

@section('page-title', 'Gestión de Clientes')

@section('content')
    {{-- Mostrar mensajes de sesión (éxito, error, etc.) --}}
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
        <a href="{{ route('admin.clients.create') }}" class="btn btn-primary">Añadir Nuevo Cliente</a>
    </div>

    @if(isset($clients) && !$clients->isEmpty())
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Edad</th>
                    <th>Género</th>
                    <th>Correo Electrónico</th>
                    <th>Teléfono</th>
                    <th>Fecha de Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clients as $client)
                    <tr>
                        <td>{{ $client->id_cliente }}</td>
                        <td>{{ $client->nombre }}</td>
                        <td>{{ $client->edad ?? 'N/A' }}</td>
                        <td>{{ $client->genero ?? 'N/A' }}</td>
                        <td>{{ $client->correo }}</td>
                        <td>{{ $client->telefono ?? 'N/A' }}</td>
                        <td>{{ $client->created_at ? $client->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                        <td>
                            <a href="{{ route('admin.clients.edit', $client->id_cliente) }}"
                                class="btn btn-sm btn-warning">Editar</a>

                            {{-- Formulario para Eliminar (AHORA ACTIVO) --}}
                            <form action="{{ route('admin.clients.destroy', $client->id_cliente) }}" method="POST"
                                style="display:inline;"
                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar este cliente? Esta acción no se puede deshacer.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay clientes registrados por el momento.</p>
    @endif
@endsection