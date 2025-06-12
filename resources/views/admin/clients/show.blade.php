@extends('layouts.app') {{-- O tu layout de admin --}}

@section('title', 'Perfil de ' . $cliente->nombre)

@push('styles')
    <style>
        /* Estilos personalizados para un look más profesional */
        .profile-header {
            background: linear-gradient(135deg, rgba(69, 97, 220, 1) 0%, rgba(36, 64, 182, 1) 100%);
            color: white;
            padding: 2rem;
            border-radius: 0.75rem;
            position: relative;
            margin-bottom: 2rem;
        }
        .profile-avatar {
            width: 100px;
            height: 100px;
            background-color: white;
            border: 4px solid #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: #4561dc;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .profile-name {
            font-weight: 700;
            font-size: 2.25rem;
        }
        .profile-email {
            opacity: 0.8;
        }
        .details-card .list-group-item {
            border: none;
            padding: 1rem 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .details-card .list-group-item:last-child {
            border-bottom: none;
        }
        .details-card .list-group-item strong {
            color: #555;
        }
        .nav-tabs .nav-link {
            color: #6c757d;
            font-weight: 600;
        }
        .nav-tabs .nav-link.active {
            color: #4561dc;
            border-color: #4561dc #4561dc #fff;
        }
        .membership-item {
            padding: 1rem;
            border: 1px solid #e9ecef;
            border-radius: 0.5rem;
            transition: all 0.2s ease-in-out;
        }
        .membership-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
        }
    </style>
@endpush

@section('content')
    <div class="container py-4">

        <div class="profile-header d-flex flex-column flex-md-row align-items-center text-center text-md-start">
            <div class="profile-avatar mb-3 mb-md-0 me-md-4">
                <i class="bi bi-person-fill"></i>
            </div>
            <div>
                <h1 class="profile-name mb-0">{{ $cliente->nombre }} {{ $cliente->apellido ?? '' }}</h1>
                <p class="profile-email mb-0">{{ $cliente->email }}</p>
            </div>
            <div class="ms-md-auto mt-3 mt-md-0">
                <a href="{{ route('admin.clients.index') }}" class="btn btn-outline-light">&larr; Volver a la lista</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="card details-card">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0"><i class="bi bi-info-circle-fill me-2"></i>Información Personal</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <strong><i class="bi bi-telephone-fill me-2 text-primary"></i>Teléfono:</strong>
                                <span>{{ $cliente->telefono ?? 'No registrado' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong><i class="bi bi-calendar-heart-fill me-2 text-primary"></i>F. Nacimiento:</strong>
                                <span>{{ $cliente->fecha_nacimiento ? \Carbon\Carbon::parse($cliente->fecha_nacimiento)->format('d/m/Y') : 'N/A' }}</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <strong><i class="bi bi-geo-alt-fill me-2 text-primary"></i>Dirección:</strong>
                                <span class="text-end">{{ $cliente->direccion ?? 'No registrada' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-transparent">
                        {{-- ===== PESTAÑAS COMPLETAS Y ACTIVAS ===== --}}
                        <ul class="nav nav-tabs card-header-tabs">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="tab" href="#membresias"><i class="bi bi-person-vcard-fill me-1"></i> Membresías</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#pagos"><i class="bi bi-receipt me-1"></i> Pagos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#asistencia"><i class="bi bi-check2-square me-1"></i> Asistencia</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="tab" href="#rutinas"><i class="bi bi-list-task me-1"></i> Rutinas</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content p-2">

                            {{-- ===== CONTENIDO DE CADA PESTAÑA ===== --}}

                            <div class="tab-pane fade show active" id="membresias">
                                @forelse ($cliente->clienteMembresias as $membresia)
                                    <div class="membership-item d-flex flex-wrap justify-content-between align-items-center mb-3">
                                        <div>
                                            <h6 class="mb-0">{{ $membresia->tipoMembresia->nombre ?? 'Plan no encontrado' }}</h6>
                                            <small class="text-muted">
                                                <i class="bi bi-calendar-check"></i> 
                                                {{ \Carbon\Carbon::parse($membresia->fecha_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($membresia->fecha_fin)->format('d/m/Y') }}
                                            </small>
                                        </div>
                                        <div>
                                            <span class="badge fs-6 rounded-pill bg-{{ $membresia->estado == 'activa' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($membresia->estado) }}
                                            </span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center p-4"><p class="text-muted">Este cliente no tiene membresías registradas.</p></div>
                                @endforelse
                                <div class="text-center mt-4">
                                    <a href="{{ route('admin.clients.memberships.create', $cliente->id_cliente) }}" class="btn btn-primary"><i class="bi bi-plus-circle-fill me-1"></i> Asignar Nueva Membresía</a>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="pagos">
                                <h5 class="mb-3">Historial de Pagos</h5>
                                @forelse($cliente->clienteMembresias->flatMap->pagos as $pago)
                                    <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                        <div>
                                            <p class="fw-bold mb-0">${{ number_format($pago->monto, 0, ',', '.') }} - <span class="fw-normal">{{ $pago->metodo_pago }}</span></p>
                                            <small class="text-muted">
                                                Membresía: {{ $pago->clienteMembresia->tipoMembresia->nombre ?? 'N/A' }}
                                            </small>
                                        </div>
                                        <span class="badge bg-info text-dark rounded-pill">{{ $pago->fecha_pago->format('d M, Y') }}</span>
                                    </li>
                                @empty
                                    <div class="text-center p-4"><p class="text-muted">Este cliente no tiene pagos registrados.</p></div>
                                @endforelse
                            </div>

                            <div class="tab-pane fade" id="asistencia">
                                <h5 class="mb-3">Historial de Asistencias</h5>
                                @forelse($cliente->asistencias as $asistencia)
                                     <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                         <div>
                                             <p class="fw-bold mb-0"><i class="bi bi-box-arrow-in-right text-success"></i> Entrada Registrada</p>
                                         </div>
                                         <span class="text-muted">{{ $asistencia->hora_entrada->format('d M, Y - h:i A') }}</span>
                                     </li>
                                 @empty
                                     <div class="text-center p-4"><p class="text-muted">Este cliente no tiene asistencias registradas.</p></div>
                                 @endforelse
                            </div>
                            
                            <div class="tab-pane fade" id="rutinas">
                                <h5 class="mb-3">Historial de Rutinas Asignadas</h5>
                                @forelse ($cliente->asignacionesRutina as $asignacion)
                                    <div class="p-2 border-bottom">
                                        <p class="fw-bold mb-0">{{ $asignacion->rutina->nombre ?? 'Rutina no encontrada' }}</p>
                                        <small class="text-muted">
                                            Asignada por: {{ $asignacion->rutina->entrenador->nombre ?? 'N/A' }} 
                                            el {{ $asignacion->fecha_asignacion->format('d/m/Y') }}
                                        </small>
                                        <span class="badge float-end bg-{{ $asignacion->estado == 'activa' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($asignacion->estado) }}
                                        </span>
                                    </div>
                                @empty
                                    <div class="text-center p-4"><p class="text-muted">Este cliente no tiene un historial de rutinas.</p></div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection