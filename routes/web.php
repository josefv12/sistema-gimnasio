<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controladores de Login
use App\Http\Controllers\Auth\Admin\LoginController as AdminLoginController;
use App\Http\Controllers\Auth\Trainer\LoginController as TrainerLoginController;
use App\Http\Controllers\Auth\Client\LoginController as ClientLoginController;

// Controladores de Dashboard
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Trainer\DashboardController as TrainerDashboardController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;

// Controladores de Gestión (Admin)
use App\Http\Controllers\Admin\ClientManagementController;
use App\Http\Controllers\Admin\TrainerManagementController;
use App\Http\Controllers\Admin\AdminManagementController;
use App\Http\Controllers\Admin\MembershipTypeController;
use App\Http\Controllers\Admin\ExerciseController;
use App\Http\Controllers\Admin\RoutineController;
use App\Http\Controllers\Admin\GroupClassController;
use App\Http\Controllers\Admin\RoutineAssignmentController;
use App\Http\Controllers\Admin\AttendanceReportController;
use App\Http\Controllers\Trainer\ClientRoutineController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// --- Rutas de Autenticación y Dashboard para Administradores ---
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminLoginController::class, 'login']);
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout')->middleware('auth:admin');
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard')->middleware('auth:admin');

    Route::middleware(['auth:admin', 'can:manage clients,admin'])->prefix('clientes')->name('clients.')->group(function () {
        Route::get('/', [ClientManagementController::class, 'index'])->name('index');
        Route::get('/crear', [ClientManagementController::class, 'create'])->name('create');
        Route::get('/{cliente}', [ClientManagementController::class, 'show'])->name('show');
        Route::post('/', [ClientManagementController::class, 'store'])->name('store');
        Route::get('/{cliente}/editar', [ClientManagementController::class, 'edit'])->name('edit');
        Route::put('/{cliente}', [ClientManagementController::class, 'update'])->name('update');
        Route::delete('/{cliente}', [ClientManagementController::class, 'destroy'])->name('destroy');

        Route::get('/{cliente}/asignar-membresia', [ClientManagementController::class, 'createMembership'])->name('memberships.create');
        Route::post('/{cliente}/asignar-membresia', [ClientManagementController::class, 'storeMembership'])->name('memberships.store');
    });

    Route::middleware(['auth:admin', 'can:manage trainers,admin'])->prefix('entrenadores')->name('trainers.')->group(function () {
        Route::get('/', [TrainerManagementController::class, 'index'])->name('index');
        Route::get('/crear', action: [TrainerManagementController::class, 'create'])->name('create');
        Route::post('/', [TrainerManagementController::class, 'store'])->name('store');
        Route::get('/{entrenador}/editar', [TrainerManagementController::class, 'edit'])->name('edit');
        Route::put('/{entrenador}', [TrainerManagementController::class, 'update'])->name('update');
        Route::delete('/{entrenador}', [TrainerManagementController::class, 'destroy'])->name('destroy');
    });

    Route::middleware(['auth:admin', 'can:manage administrators,admin'])->group(function () {
        Route::get('/administradores', [AdminManagementController::class, 'index'])->name('admins.index');
    });

    Route::middleware(['auth:admin', 'can:manage memberships,admin'])->prefix('tipos-membresia')->name('membership_types.')->group(function () {
        Route::get('/', [MembershipTypeController::class, 'index'])->name('index');
        Route::get('/crear', [MembershipTypeController::class, 'create'])->name('create');
        Route::post('/', [MembershipTypeController::class, 'store'])->name('store');
        Route::get('/{tipoMembresia}/editar', [MembershipTypeController::class, 'edit'])->name('edit');
        Route::put('/{tipoMembresia}', [MembershipTypeController::class, 'update'])->name('update');
        Route::delete('/{tipoMembresia}', [MembershipTypeController::class, 'destroy'])->name('destroy');
    });

    Route::middleware(['auth:admin', 'can:manage exercises,admin'])->prefix('ejercicios')->name('exercises.')->group(function () {
        Route::get('/', [ExerciseController::class, 'index'])->name('index');
        Route::get('/crear', [ExerciseController::class, 'create'])->name('create');
        Route::post('/', [ExerciseController::class, 'store'])->name('store');
        Route::get('/{ejercicio}/editar', [ExerciseController::class, 'edit'])->name('edit');
        Route::put('/{ejercicio}', [ExerciseController::class, 'update'])->name('update');
        Route::delete('/{ejercicio}', [ExerciseController::class, 'destroy'])->name('destroy');
    });

    Route::middleware(['auth:admin', 'can:manage routines,admin'])->prefix('rutinas')->name('routines.')->group(function () {
        Route::get('/', [RoutineController::class, 'index'])->name('index');
        Route::get('/crear', [RoutineController::class, 'create'])->name('create');
        Route::post('/', [RoutineController::class, 'store'])->name('store');
        Route::get('/{rutina}', [RoutineController::class, 'show'])->name('show');
        Route::get('/{rutina}/editar', [RoutineController::class, 'edit'])->name('edit');
        Route::put('/{rutina}', [RoutineController::class, 'update'])->name('update');
        Route::delete('/{rutina}', [RoutineController::class, 'destroy'])->name('destroy');
        Route::post('/{rutina}/ejercicios', [RoutineController::class, 'addExercise'])->name('add_exercise');
        Route::delete('/{rutina}/ejercicios/{ejercicio}', [RoutineController::class, 'removeExercise'])->name('remove_exercise');
        Route::get('/{rutina}/ejercicio-pivot/{rutinaEjercicio}/editar', [RoutineController::class, 'editExerciseDetails'])->name('edit_exercise_details');
        Route::put('/{rutina}/ejercicio-pivot/{rutinaEjercicio}', [RoutineController::class, 'updateExerciseDetails'])->name('update_exercise_details');
    });

    Route::middleware(['auth:admin', 'can:manage classes,admin'])->prefix('clases-grupales')->name('group_classes.')->group(function () {
        Route::get('/', [GroupClassController::class, 'index'])->name('index');
        Route::get('/crear', [GroupClassController::class, 'create'])->name('create');
        Route::post('/', [GroupClassController::class, 'store'])->name('store');
        Route::get('/{claseGrupal}', [GroupClassController::class, 'show'])->name('show');
        Route::get('/{claseGrupal}/editar', [GroupClassController::class, 'edit'])->name('edit');
        Route::put('/{claseGrupal}', [GroupClassController::class, 'update'])->name('update');
        Route::delete('/{claseGrupal}', [GroupClassController::class, 'destroy'])->name('destroy');
        Route::post('/reservas/{clienteClaseReserva}/marcar-asistencia', [GroupClassController::class, 'markAttendance'])->name('mark_attendance');
    });

    Route::middleware(['auth:admin', 'can:manage routines,admin'])->prefix('asignaciones-rutina')->name('routine_assignments.')->group(function () {
        Route::get('/', [RoutineAssignmentController::class, 'index'])->name('index');
        Route::get('/crear', [RoutineAssignmentController::class, 'create'])->name('create');
        Route::post('/', [RoutineAssignmentController::class, 'store'])->name('store');
        Route::get('/{asignacionRutinaCliente}/editar', [RoutineAssignmentController::class, 'edit'])->name('edit');
        Route::put('/{asignacionRutinaCliente}', [RoutineAssignmentController::class, 'update'])->name('update');
        Route::delete('/{asignacionRutinaCliente}', [RoutineAssignmentController::class, 'destroy'])->name('destroy');
    });

    Route::get('/reporte-asistencias', [AttendanceReportController::class, 'index'])
        ->name('attendances.report')
        ->middleware(['auth:admin', 'can:view general attendance history,admin']);
});

// --- Rutas de Autenticación y Dashboard para Entrenadores ---
Route::prefix('trainer')->name('trainer.')->group(function () {
    Route::get('/login', [TrainerLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [TrainerLoginController::class, 'login']);
    Route::post('/logout', [TrainerLoginController::class, 'logout'])->name('logout')->middleware('auth:trainer');
    Route::get('/dashboard', [TrainerDashboardController::class, 'index'])->name('dashboard')->middleware('auth:trainer');
    Route::get('/mis-clases', [TrainerDashboardController::class, 'listMyClasses'])->name('my_classes.list')->middleware('auth:trainer');
    Route::get('/mis-clases/{claseGrupal}/asistencia', [TrainerDashboardController::class, 'showClassForAttendance'])->name('my_classes.attendance')->middleware('auth:trainer');
    Route::post('/mis-clases/reservas/{clienteClaseReserva}/marcar-asistencia', [TrainerDashboardController::class, 'markTrainerAttendance'])->name('my_classes.mark_attendance_action')->middleware('auth:trainer');
    Route::get('/mis-clientes', [TrainerDashboardController::class, 'listMyClients'])->name('my_clients.list')->middleware('auth:trainer');
    Route::get('/clientes/{cliente}/progreso', [TrainerDashboardController::class, 'showClientProgress'])->name('clients.progress_tracking')->middleware('auth:trainer');
    Route::get('/clientes/{cliente}/progreso/crear', [TrainerDashboardController::class, 'createClientProgress'])->name('clients.progress.create')->middleware('auth:trainer');
    Route::post('/clientes/{cliente}/progreso', [TrainerDashboardController::class, 'storeClientProgress'])->name('clients.progress.store')->middleware('auth:trainer');
    Route::post('/clientes/{cliente}/registrar-asistencia', [TrainerDashboardController::class, 'registerAttendance'])->name('clients.attendance.store')->middleware('auth:trainer');

    Route::get('/clientes/{cliente}/rutina', [ClientRoutineController::class, 'index'])->name('clients.routine.index');
    Route::post('/clientes/{cliente}/rutina', [ClientRoutineController::class, 'store'])->name('clients.routine.store');

    // ===== INICIO DE LA MODIFICACIÓN =====
    // Nota: Usamos {rutina} en lugar de {cliente} porque la acción es sobre la rutina.
    Route::post('/rutinas/{rutina}/ejercicios', [ClientRoutineController::class, 'addExercise'])->name('clients.routine.add_exercise');
    // ===== FIN DE LA MODIFICACIÓN =====
});

// --- Rutas de Autenticación y Dashboard para Clientes ---
Route::prefix('cliente')->name('client.')->group(function () {
    Route::get('/login', [ClientLoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [ClientLoginController::class, 'login']);
    Route::post('/logout', [ClientLoginController::class, 'logout'])->name('logout')->middleware('auth:web');
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard')->middleware('auth:web');
    Route::get('/clases-grupales', [ClientDashboardController::class, 'listGroupClasses'])->name('group_classes.list')->middleware('auth:web');
    Route::post('/clases-grupales/{claseGrupal}/reservar', [ClientRoutineController::class, 'bookClass'])->name('group_classes.book');
    Route::get('/mis-reservas', [ClientDashboardController::class, 'myBookings'])->name('my_bookings')->middleware('auth:web');
    Route::delete('/mis-reservas/{clienteClaseReserva}/cancelar', [ClientRoutineController::class, 'cancelBooking'])->name('bookings.cancel');
    Route::get('/mi-progreso', [ClientDashboardController::class, 'myProgress'])->name('my_progress')->middleware('auth:web');
    Route::get('/mi-rutina', [ClientDashboardController::class, 'myRoutine'])->name('my_routine')->middleware('auth:web');
    Route::get('/mi-membresia', [ClientDashboardController::class, 'myMembership'])->name('my_membership')->middleware('auth:web');
});