@extends('layouts.trainer')

@section('title', 'Mis Clientes')

@section('page-title', 'Listado de Clientes')

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

    @if(isset($clients) && !$clients->isEmpty())
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Clientes</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Edad</th>
                            <th>Género</th>
                            <th>Correo</th>
                            <th>Teléfono</th>
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
                                <td>
                                    {{-- Enlace para ver/gestionar progreso (AHORA ACTIVO) --}}
                                    <a href="{{ route('trainer.clients.progress_tracking', $client->id_cliente) }}"
                                        class="btn btn-sm btn-primary">Ver/Registrar Progreso</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $clients->links() }}
        </div>
    @else
        <div class="alert alert-info">
            No hay clientes registrados en el sistema o asignados a ti por el momento.
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('trainer.dashboard') }}" class="btn btn-secondary"><i class="bi bi-arrow-left-circle"></i> Volver
            al Dashboard</a>
    </div>
@endsection