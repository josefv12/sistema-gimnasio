@extends('layouts.trainer') {{-- O el layout que hayas definido para el entrenador --}}

@section('title', 'Mis Clases Programadas')

@section('page-title', 'Mis Clases Programadas')

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(isset($myClasses) && !$myClasses->isEmpty())
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Próximas Clases</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Nombre de la Clase</th>
                            <th>Fecha</th>
                            <th>Hora Inicio</th>
                            <th>Hora Fin</th>
                            <th>Cupo Máx.</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($myClasses as $class)
                            <tr>
                                <td>{{ $class->nombre }}</td>
                                <td>{{ $class->fecha->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($class->hora_inicio)->format('h:i A') }}</td>
                                <td>{{ $class->hora_fin ? \Carbon\Carbon::parse($class->hora_fin)->format('h:i A') : 'N/A' }}</td>
                                <td>{{ $class->cupo_maximo }}</td>
                                <td>
                                    @if($class->estado == 'programada')
                                        <span class="badge bg-info text-dark">Programada</span>
                                    @elseif($class->estado == 'confirmada')
                                        <span class="badge bg-success">Confirmada</span>
                                    @else
                                        <span class="badge bg-light text-dark">{{ ucfirst($class->estado) }}</span>
                                    @endif
                                </td>
                                <td>
                                    {{-- Enlace para ver inscritos y marcar asistencia (funcionalidad futura) --}}
                                    <a href="{{ route('trainer.my_classes.attendance', $class->id_clase) }}"
                                        class="btn btn-sm btn-outline-primary">Ver Inscritos / Asistencia</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $myClasses->links() }}
        </div>
    @else
        <div class="alert alert-info">
            No tienes clases programadas por el momento.
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('trainer.dashboard') }}" class="btn btn-secondary"><i class="bi bi-arrow-left-circle"></i> Volver
            al Dashboard</a>
    </div>
@endsection