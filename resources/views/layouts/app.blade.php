<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Gimnasio Pro - Cliente')</title>

    {{-- Assets de Bootstrap (CSS y JS) desde CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Estilos personalizados para el layout --}}
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #495057;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .navbar-custom {
            background-color: #343a40;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link {
            color: #f8f9fa;
        }

        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: #ffffff;
            font-weight: 500;
        }

        .navbar-custom .btn-logout {
            color: #f8f9fa;
            background-color: transparent;
            border: none;
        }

        .navbar-custom .btn-logout:hover {
            color: #ffffff;
        }

        .page-title {
            color: #343a40;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #007bff;
            padding-bottom: 0.5rem;
            display: inline-block;
        }

        .card {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .card-header.bg-primary {
            color: white;
        }

        .content-wrapper {
            flex: 1;
            /* Empuja el footer hacia abajo */
        }

        .footer {
            background-color: #343a40;
            color: #adb5bd;
            padding: 1rem 0;
            text-align: center;
            font-size: 0.9em;
        }

        .btn {
            text-decoration: none !important;
        }
    </style>
    @stack('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('client.dashboard') }}">Gimnasio Pro</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavClient"
                aria-controls="navbarNavClient" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavClient">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('client.dashboard') ? 'active' : '' }}"
                            href="{{ route('client.dashboard') }}"><i class="bi bi-house-door"></i> Mi Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('client.group_classes.list') ? 'active' : '' }}"
                            href="{{ route('client.group_classes.list') }}"><i class="bi bi-calendar-event"></i> Clases
                            Grupales</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('client.my_bookings') ? 'active' : '' }}"
                            href="{{ route('client.my_bookings') }}"><i class="bi bi-journal-check"></i> Mis
                            Reservas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('client.my_progress') ? 'active' : '' }}"
                            href="{{ route('client.my_progress') }}">
                            <i class="bi bi-graph-up"></i> Mi Progreso
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('client.my_routine') ? 'active' : '' }}"
                            href="{{ route('client.my_routine') }}">
                            <i class="bi bi-list-task"></i> Mi Rutina
                        </a>
                    </li>

                    {{-- ===== INICIO DE LA MODIFICACIÓN ===== --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('client.my_membership') ? 'active' : '' }}"
                            href="{{ route('client.my_membership') }}">
                            <i class="bi bi-person-vcard"></i> Mi Membresía
                        </a>
                    </li>
                    {{-- ===== FIN DE LA MODIFICACIÓN ===== --}}

                    <li class="nav-item">
                        <form method="POST" action="{{ route('client.logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link"
                                style="padding: 0.5rem 0; display: inline; vertical-align: baseline;">
                                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4 content-wrapper">
        @yield('content')
    </div>

    <footer class="footer">
        <div class="container">
            &copy; {{ date('Y') }} Gimnasio Pro. Todos los derechos reservados.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>