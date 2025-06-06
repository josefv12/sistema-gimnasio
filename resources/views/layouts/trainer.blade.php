<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Panel de Entrenador') - Gimnasio Pro</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #495057;
            display: flex;
            min-height: 100vh;
            margin: 0;
        }

        .sidebar {
            width: 250px;
            background-color: #28a745;
            color: #fff;
            padding-top: 1rem;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            box-sizing: border-box;
            overflow-y: auto;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, .15);
        }

        .sidebar-header {
            padding: 0.75rem 1.25rem;
            text-align: center;
            margin-bottom: 1rem;
            border-bottom: 1px solid #20893a;
        }

        .sidebar-header h2 {
            color: #fff;
            font-size: 1.5em;
            margin: 0;
        }

        .sidebar-nav {
            flex-grow: 1;
        }

        .sidebar .nav-link {
            color: #e9ecef;
            padding: 0.65rem 1.25rem;
            display: block;
            text-decoration: none;
            border-radius: 0.25rem;
            margin: 0.1rem 0.5rem;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background-color: #218838;
        }

        .sidebar .nav-link.active {
            color: #fff;
            background-color: #1e7e34;
            font-weight: 500;
        }

        .sidebar .nav-link .bi {
            margin-right: 0.5rem;
        }

        .sidebar .logout-form {
            padding: 1.25rem;
            margin-top: auto;
            border-top: 1px solid #20893a;
        }

        .main-content {
            margin-left: 250px;
            padding: 1.5rem;
            width: calc(100% - 250px);
            box-sizing: border-box;
            overflow-y: auto;
        }

        .page-title {
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
            color: #343a40;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #28a745;
            display: inline-block;
        }

        .footer {
            background-color: #343a40;
            color: #adb5bd;
            padding: 1rem 0;
            text-align: center;
            font-size: 0.9em;
            margin-top: auto;
        }

        .btn {
            text-decoration: none !important;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, .075);
        }

        .alert {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, .075);
        }

        .table {
            word-wrap: break-word;
            white-space: normal;
        }
    </style>
    @stack('styles')
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Gimnasio Pro</h2>
        </div>
        <ul class="nav flex-column sidebar-nav">
            <li class="nav-item">
                <a href="{{ route('trainer.dashboard') }}"
                    class="nav-link {{ request()->routeIs('trainer.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-layout-wtf"></i>Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('trainer.my_classes.list') }}"
                    class="nav-link {{ request()->routeIs('trainer.my_classes.list') || request()->routeIs('trainer.my_classes.attendance') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check-fill"></i>Mis Clases
                </a>
            </li>
            {{-- ENLACE PARA MIS CLIENTES (AHORA ACTIVO) --}}
            <li class="nav-item">
                <a href="{{ route('trainer.my_clients.list') }}"
                    class="nav-link {{ request()->routeIs('trainer.my_clients.list') ? 'active' : '' }}">
                    <i class="bi bi-people-fill"></i>Mis Clientes
                </a>
            </li>
            {{-- Aquí puedes añadir más enlaces para el entrenador en el futuro --}}
            {{-- Por ejemplo:
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-card-checklist"></i>Gestionar Mis Rutinas
                </a>
            </li>
            --}}
        </ul>

        <form method="POST" action="{{ route('trainer.logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="btn btn-light w-100"><i class="bi bi-box-arrow-right me-2"></i>Cerrar
                Sesión</button>
        </form>
    </aside>

    <main class="main-content">
        <header class="content-header mb-4">
            <h1 class="page-title">@yield('page-title', 'Panel de Entrenador')</h1>
        </header>

        <div class="container-fluid">
            @yield('content')
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            &copy; {{ date('Y') }} Gimnasio Pro. Todos los derechos reservados.
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>