@extends('layouts.admin')

@section('title', 'Reporte de Asistencias')

@section('page-title', 'Reporte de Asistencias')

@section('content')

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.attendances.report') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-md-4">
                    <label for="fecha_busqueda" class="form-label">Filtrar por fecha:</label>
                    <input type="date" class="form-control" id="fecha_busqueda" name="fecha_busqueda"
                        value="{{ request('fecha_busqueda') }}">
                </div>
                <div class="col-md-auto mt-auto">
                    <button type="submit" class="btn btn-info">Filtrar</button>
                    <a href="{{ route('admin.attendances.report') }}" class="btn btn-secondary">Limpiar</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($asistencias->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Cliente</th>
                                <th>Correo del Cliente</th>
                                <th>Fecha y Hora del Check-in</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($asistencias as $asistencia)
                                <tr>
                                    <td>{{ $asistencia->cliente->nombre ?? 'Cliente no encontrado' }}</td>
                                    <td>{{ $asistencia->cliente->correo ?? 'N/A' }}</td>
                                    <td>{{ $asistencia->hora_entrada->format('d F, Y - h:i A') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $asistencias->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center p-4">
                    <p class="text-muted fs-5">
                        @if(request('fecha_busqueda'))
                            No se encontraron asistencias para la fecha seleccionada.
                        @else
                            No hay asistencias registradas por el momento.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection