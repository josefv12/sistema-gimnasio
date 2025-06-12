@extends('layouts.admin')

@section('title', 'Gestionar Clientes')

@section('page-title', 'Gestión de Clientes')

@section('content')
    {{-- Mostrar mensajes de sesión (éxito, error, etc.) --}}
    @if (session('success'))
        <div class="alert alert-success mb-3" role="alert">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger mb-3" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.clients.create') }}" class="btn btn-primary"><i
                class="bi bi-person-plus-fill me-2"></i>Añadir Nuevo Cliente</a>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.clients.index') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-5">
                    <label for="search" class="visually-hidden">Buscar</label>
                    <input type="text" class="form-control" id="search" name="search"
                        placeholder="Buscar por nombre o correo..." value="{{ request('search') }}">
                </div>
                <div class="col-md-auto">
                    <button type="submit" class="btn btn-info"><i class="bi bi-search me-2"></i>Buscar</button>
                    @if(request('search'))
                        <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary"><i class="bi bi-x"></i>
                            Limpiar</a>
                    @endif
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            @if($clients->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Correo Electrónico</th>
                                <th>Teléfono</th>
                                <th>Fecha de Registro</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td>{{ $client->id_cliente }}</td>
                                    <td>{{ $client->nombre }}</td>
                                    <td>{{ $client->correo }}</td>
                                    <td>{{ $client->telefono ?? 'N/A' }}</td>
                                    <td>{{ $client->created_at->format('d/m/Y') }}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{ route('admin.clients.show', $client->id_cliente) }}"
                                                class="btn btn-sm btn-info" title="Ver Detalles">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            <a href="{{ route('admin.clients.edit', $client->id_cliente) }}"
                                                class="btn btn-sm btn-warning" title="Editar">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('admin.clients.destroy', $client->id_cliente) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar a este cliente?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $clients->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center p-4">
                    @if(request('search'))
                        <p class="text-muted fs-5">No se encontraron clientes que coincidan con tu búsqueda.</p>
                        <a href="{{ route('admin.clients.index') }}" class="btn btn-secondary mt-2">Limpiar Búsqueda</a>
                    @else
                        <p class="text-muted fs-5">No hay clientes registrados por el momento.</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection