<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Administrador; // Asegúrate que la ruta a tu modelo es correcta
use App\Models\Entrenador;   // Asegúrate que la ruta a tu modelo es correcta
use App\Models\Cliente;      // Asegúrate que la ruta a tu modelo es correcta
use App\Models\TipoMembresia; // <-- AÑADIDO: Importa el modelo TipoMembresia
use Illuminate\Support\Facades\Hash;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Restablecer permisos y roles cacheados
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // --- 1. Crear Permisos (Especificando Guards) ---
        // Basado en los roles Administrador, Entrenador, Cliente

        // Permisos Generales/Usuarios
        Permission::create(['name' => 'view dashboards', 'guard_name' => 'admin']);
        Permission::create(['name' => 'view dashboards', 'guard_name' => 'trainer']);
        Permission::create(['name' => 'view dashboards', 'guard_name' => 'web']); // Para Cliente

        Permission::create(['name' => 'manage own profile', 'guard_name' => 'admin']);
        Permission::create(['name' => 'manage own profile', 'guard_name' => 'trainer']);
        Permission::create(['name' => 'manage own profile', 'guard_name' => 'web']); // Para Cliente

        // Permisos de Administración General (Principalmente para Admin)
        Permission::create(['name' => 'manage administrators', 'guard_name' => 'admin']);
        Permission::create(['name' => 'manage trainers', 'guard_name' => 'admin']);
        Permission::create(['name' => 'manage clients', 'guard_name' => 'admin']); // Gestión general de clientes por admin
        Permission::create(['name' => 'view all users', 'guard_name' => 'admin']);

        // Permisos de Gestión de Clientes, Membresías, Pagos
        Permission::create(['name' => 'view clients list', 'guard_name' => 'admin']);
        Permission::create(['name' => 'view clients list', 'guard_name' => 'trainer']);

        Permission::create(['name' => 'create clients', 'guard_name' => 'admin']);
        Permission::create(['name' => 'edit clients', 'guard_name' => 'admin']);
        Permission::create(['name' => 'delete clients', 'guard_name' => 'admin']);

        Permission::create(['name' => 'manage memberships', 'guard_name' => 'admin']); // CRUD Tipos de membresía
        Permission::create(['name' => 'assign client membership', 'guard_name' => 'admin']);

        Permission::create(['name' => 'view client membership details', 'guard_name' => 'admin']);
        Permission::create(['name' => 'view client membership details', 'guard_name' => 'trainer']);

        Permission::create(['name' => 'view own membership', 'guard_name' => 'web']); // Cliente ve SU membresía

        Permission::create(['name' => 'manage payments', 'guard_name' => 'admin']);

        Permission::create(['name' => 'view client payment history', 'guard_name' => 'admin']);
        Permission::create(['name' => 'view client payment history', 'guard_name' => 'trainer']);

        Permission::create(['name' => 'view own payment history', 'guard_name' => 'web']); // Cliente ve SU historial

        // Permisos de Gestión de Rutinas y Ejercicios
        Permission::create(['name' => 'manage exercises', 'guard_name' => 'admin']);
        Permission::create(['name' => 'manage exercises', 'guard_name' => 'trainer']);

        Permission::create(['name' => 'view exercises list', 'guard_name' => 'admin']);
        Permission::create(['name' => 'view exercises list', 'guard_name' => 'trainer']);
        Permission::create(['name' => 'view exercises list', 'guard_name' => 'web']);

        Permission::create(['name' => 'manage routines', 'guard_name' => 'admin']);
        Permission::create(['name' => 'manage routines', 'guard_name' => 'trainer']);

        Permission::create(['name' => 'view routines list', 'guard_name' => 'admin']);
        Permission::create(['name' => 'view routines list', 'guard_name' => 'trainer']);

        Permission::create(['name' => 'assign routine to client', 'guard_name' => 'admin']);
        Permission::create(['name' => 'assign routine to client', 'guard_name' => 'trainer']);

        Permission::create(['name' => 'view assigned routine details', 'guard_name' => 'admin']);
        Permission::create(['name' => 'view assigned routine details', 'guard_name' => 'trainer']);
        Permission::create(['name' => 'view assigned routine details', 'guard_name' => 'web']);

        // Permisos de Gestión de Clases Grupales
        Permission::create(['name' => 'manage classes', 'guard_name' => 'admin']);
        Permission::create(['name' => 'manage classes', 'guard_name' => 'trainer']);

        Permission::create(['name' => 'view classes list', 'guard_name' => 'admin']);
        Permission::create(['name' => 'view classes list', 'guard_name' => 'trainer']);
        Permission::create(['name' => 'view classes list', 'guard_name' => 'web']);

        Permission::create(['name' => 'manage class attendance', 'guard_name' => 'admin']);
        Permission::create(['name' => 'manage class attendance', 'guard_name' => 'trainer']);

        Permission::create(['name' => 'book class', 'guard_name' => 'web']);

        Permission::create(['name' => 'view own class reservations', 'guard_name' => 'web']);

        // Permisos de Gestión de Asistencia General (al gimnasio)
        Permission::create(['name' => 'register general attendance', 'guard_name' => 'admin']);

        Permission::create(['name' => 'view general attendance history', 'guard_name' => 'admin']);
        Permission::create(['name' => 'view general attendance history', 'guard_name' => 'trainer']);
        Permission::create(['name' => 'view own general attendance history', 'guard_name' => 'web']);

        // Permisos de Seguimiento de Progreso
        Permission::create(['name' => 'manage client progress', 'guard_name' => 'admin']);
        Permission::create(['name' => 'manage client progress', 'guard_name' => 'trainer']);

        Permission::create(['name' => 'view own progress', 'guard_name' => 'web']);

        // Permisos de Reportes
        Permission::create(['name' => 'view reports', 'guard_name' => 'admin']);


        // --- 2. Crear Roles (Especificando Guards) ---
        $roleAdmin = Role::create(['name' => 'administrador', 'guard_name' => 'admin']);
        $roleEntrenador = Role::create(['name' => 'entrenador', 'guard_name' => 'trainer']);
        $roleCliente = Role::create(['name' => 'cliente', 'guard_name' => 'web']);


        // --- 3. Asignar Permisos a Roles ---

        // Administrador:
        $roleAdmin->givePermissionTo([
            'view dashboards',
            'manage own profile',
            'manage administrators',
            'manage trainers',
            'manage clients',
            'view all users',
            'view clients list',
            'create clients',
            'edit clients',
            'delete clients',
            'manage memberships',
            'assign client membership',
            'view client membership details',
            'manage payments',
            'view client payment history',
            'manage exercises',
            'view exercises list',
            'manage routines',
            'view routines list',
            'assign routine to client',
            'view assigned routine details',
            'manage classes',
            'view classes list',
            'manage class attendance',
            'register general attendance',
            'view general attendance history',
            'manage client progress',
            'view reports',
        ]);

        // Entrenador:
        $roleEntrenador->givePermissionTo([
            'view dashboards',
            'manage own profile',
            'view clients list',
            'view client membership details',
            'view client payment history',
            'view exercises list',
            'manage exercises',
            'view routines list',
            'manage routines',
            'assign routine to client',
            'view assigned routine details',
            'view classes list',
            'manage classes',
            'manage class attendance',
            'view general attendance history',
            'manage client progress',
        ]);

        // Cliente:
        $roleCliente->givePermissionTo([
            'view dashboards',
            'manage own profile',
            'view own membership',
            'view own payment history',
            'view exercises list',
            'view assigned routine details',
            'view classes list',
            'book class',
            'view own class reservations',
            'view own general attendance history',
            'view own progress',
        ]);


        // --- 4. Crear Usuarios Iniciales y Asignarles Roles ---

        // Usuario Administrador
        $adminUser = Administrador::create([
            'nombre' => 'Admin Principal',
            'correo' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'telefono' => '3045673212',
        ]);
        $adminUser->assignRole('administrador');

        // Usuario Entrenador
        $trainerUser = Entrenador::create([
            'nombre' => 'Entrenador Jefe',
            'especialidad' => 'Piernas',
            'correo' => 'trainer@gmail.com',
            'password' => Hash::make('password'),
            'telefono' => '3044985432',
        ]);
        $trainerUser->assignRole('entrenador');

        // Usuario Cliente
        $clientUser = Cliente::create([
            'nombre' => 'Jose Bernal',
            'edad' => 30,
            'genero' => 'M',
            'correo' => 'bernaljose98@gmail.com',
            'password' => Hash::make('password'),
            'telefono' => '3042701845',
        ]);
        $clientUser->assignRole('cliente');

        // --- 5. Crear Tipos de Membresía Iniciales --- // <-- AÑADIDO
        TipoMembresia::create([
            'nombre' => 'Membresía Básica',
            'descripcion' => 'Acceso a todas las áreas de máquinas y cardio.',
            'duracion_dias' => 30,
            'precio' => 50000.00,
            'estado' => 'activo',
        ]);

        TipoMembresia::create([
            'nombre' => 'Membresía Plus',
            'descripcion' => 'Acceso a máquinas, cardio y todas las clases grupales.',
            'duracion_dias' => 30,
            'precio' => 80000.00,
            'estado' => 'activo',
        ]);

        TipoMembresia::create([
            'nombre' => 'Membresía Anual VIP',
            'descripcion' => 'Acceso ilimitado a todo, incluye seguimiento personalizado.',
            'duracion_dias' => 365,
            'precio' => 750000.00,
            'estado' => 'activo',
        ]);

        $this->command->info('Tipos de membresía iniciales creados.'); // <-- AÑADIDO
    }
}