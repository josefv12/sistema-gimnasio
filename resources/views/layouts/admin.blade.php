<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel de Administrador') - Gimnasio Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            background-color: #f8f9fa;
            color: #495057;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #212529;
            color: #dee2e6;
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
            border-bottom: 1px solid #343a40;
        }

        .sidebar-header h2 {
            color: #fff;
            font-size: 1.5em;
            margin: 0;
        }

        .sidebar-nav {
            list-style: none;
            padding: 0;
            margin: 0;
            flex-grow: 1;
        }

        .sidebar .nav-link {
            color: #adb5bd;
            padding: 0.65rem 1.25rem;
            display: block;
            text-decoration: none;
            border-radius: 0.25rem;
            margin: 0.1rem 0.5rem;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background-color: #343a40;
        }

        .sidebar .nav-link.active {
            color: #fff;
            background-color: #007bff;
        }

        .sidebar .nav-link .bi {
            margin-right: 0.5rem;
        }

        .sidebar .logout-form {
            padding: 1.25rem;
            margin-top: auto;
            border-top: 1px solid #343a40;
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
            border-bottom: 2px solid #007bff;
            display: inline-block;
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
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door"></i>Dashboard
                </a>
            </li>

            @can('manage clients', 'admin')
                <li class="nav-item">
                    <a href="{{ route('admin.clients.index') }}"
                        class="nav-link {{ request()->routeIs('admin.clients.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>Gestionar Clientes
                    </a>
                </li>
            @endcan

            @can('manage trainers', 'admin')
                <li class="nav-item">
                    <a href="{{ route('admin.trainers.index') }}"
                        class="nav-link {{ request()->routeIs('admin.trainers.*') ? 'active' : '' }}">
                        <i class="bi bi-person-video3"></i>Gestionar Entrenadores
                    </a>
                </li>
            @endcan

            @can('manage administrators', 'admin')
                <li class="nav-item">
                    <a href="{{ route('admin.admins.index') }}"
                        class="nav-link {{ request()->routeIs('admin.admins.*') ? 'active' : '' }}">
                        <i class="bi bi-person-badge"></i>Gestionar Administradores
                    </a>
                </li>
            @endcan

            @can('manage memberships', 'admin')
                <li class="nav-item">
                    <a href="{{ route('admin.membership_types.index') }}"
                        class="nav-link {{ request()->routeIs('admin.membership_types.*') ? 'active' : '' }}">
                        <i class="bi bi-card-list"></i>Gestionar Tipos de Membresía
                    </a>
                </li>
            @endcan

            @can('manage exercises', 'admin')
                <li class="nav-item">
                    <a href="{{ route('admin.exercises.index') }}"
                        class="nav-link {{ request()->routeIs('admin.exercises.*') ? 'active' : '' }}">
                        <i class="bi bi-activity"></i>Gestionar Ejercicios
                    </a>
                </li>
            @endcan



            @can('manage routines', 'admin')
                <li class="nav-item">
                    <a href="{{ route('admin.routine_assignments.index') }}"
                        class="nav-link {{ request()->routeIs('admin.routine_assignments.*') ? 'active' : '' }}">
                        <i class="bi bi-journal-bookmark-fill"></i>Gestionar Asignaciones
                    </a>
                </li>
            @endcan

            @can('view general attendance history', 'admin')
                <li class="nav-item">
                    <a href="{{ route('admin.attendances.report') }}"
                        class="nav-link {{ request()->routeIs('admin.attendances.report') ? 'active' : '' }}">
                        <i class="bi bi-file-earmark-bar-graph-fill"></i>Reporte de Asistencias
                    </a>
                </li>
            @endcan
            @can('manage classes', 'admin')
                <li class="nav-item">
                    <a href="{{ route('admin.group_classes.index') }}"
                        class="nav-link {{ request()->routeIs('admin.group_classes.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-event-fill"></i>Gestionar Clases Grupales
                    </a>
                </li>
            @endcan

        </ul>
        <form method="POST" action="{{ route('admin.logout') }}" class="logout-form">
            @csrf
            <button type="submit" class="btn btn-danger w-100"><i class="bi bi-box-arrow-right me-2"></i>Cerrar
                Sesión</button>
        </form>
    </aside>

    <main class="main-content">
        <header class="content-header">
            <h1 class="page-title">@yield('page-title', 'Panel')</h1>
        </header>

        <div class="container-fluid">
            @yield('content')
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>