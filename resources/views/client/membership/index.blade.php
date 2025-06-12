@extends('layouts.app')

@section('title', 'Mi Membresía y Pagos')

@section('content')
    <div class="container">
        <h1 class="page-title">Mi Membresía y Pagos</h1>

        {{-- Tarjeta para la Membresía Activa --}}
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="bi bi-person-vcard-fill me-2"></i>Estado Actual de la Membresía</h4>
            </div>
            <div class="card-body">
                @if($activeMembership)
                    <h5 class="card-title">{{ $activeMembership->tipoMembresia->nombre ?? 'N/A' }}</h5>
                    <p class="card-text">
                        Tu membresía está <strong>activa</strong> y es válida hasta el:
                        <strong>{{ $activeMembership->fecha_fin->format('d/m/Y') }}</strong>.
                    </p>
                    <p>
                        @php
                            $diasRestantes = now()->diffInDays($activeMembership->fecha_fin, false);
                        @endphp
                        @if($diasRestantes >= 0)
                            <span class="badge bg-primary fs-6">Te quedan {{ $diasRestantes }} día(s)</span>
                        @else
                            <span class="badge bg-danger fs-6">Tu membresía ha expirado.</span>
                        @endif
                    </p>
                @else
                    <p class="text-danger fw-bold">No tienes una membresía activa en este momento.</p>
                    <p>Contacta con la administración para renovar o adquirir un nuevo plan.</p>
                @endif
            </div>
        </div>

        {{-- Tarjeta para el Historial de Membresías y Pagos --}}
        <div class="card shadow-sm">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Historial de Membresías</h5>
            </div>
            @if($membershipHistory->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Plan de Membresía</th>
                                <th>Periodo</th>
                                <th>Estado</th>
                                <th>Pagos Realizados</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($membershipHistory as $membership)
                                <tr>
                                    <td><strong>{{ $membership->tipoMembresia->nombre ?? 'N/A' }}</strong></td>
                                    <td>{{ $membership->fecha_inicio->format('d/m/Y') }} -
                                        {{ $membership->fecha_fin->format('d/m/Y') }}
                                    </td>
                                    <td>
                                        @if($membership->estado == 'activa')
                                            <span class="badge bg-success">Activa</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($membership->estado) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($membership->pagos->isNotEmpty())
                                            <ul class="list-unstyled mb-0">
                                                @foreach($membership->pagos as $pago)
                                                    <li>
                                                        ${{ number_format($pago->monto, 0, ',', '.') }} - {{ $pago->metodo_pago }}
                                                        <small class="text-muted">({{ $pago->fecha_pago->format('d/m/Y') }})</small>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <small class="text-muted">No hay pagos registrados para esta membresía.</small>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($membershipHistory->hasPages())
                    <div class="card-footer d-flex justify-content-center">
                        {{ $membershipHistory->links() }}
                    </div>
                @endif
            @else
                <div class="card-body">
                    <p class="text-muted fst-italic">No tienes un historial de membresías.</p>
                </div>
            @endif
        </div>

        <div class="mt-4">
            <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left-circle"></i> Volver al Dashboard
            </a>
        </div>
    </div>
@endsection