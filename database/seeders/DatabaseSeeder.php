<?php

namespace Database\Seeders;

// Ya no necesitamos importar User si no lo usamos aquí
// use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// Asegúrate de que tu RolesAndPermissionsSeeder esté importado si no está en el mismo namespace
use Database\Seeders\RolesAndPermissionsSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Comentamos estas líneas ya que no estamos usando el User Factory por defecto
        // User::factory(10)->create();

        // Comentamos la creación del usuario de prueba por defecto
        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // --- Llama a los seeders que quieres ejecutar ---
        // Asegúrate de que tu RolesAndPermissionsSeeder esté aquí
        $this->call([
            RolesAndPermissionsSeeder::class, // <-- Esta línea llama a tu seeder de roles y permisos
            // Puedes añadir llamadas a otros seeders aquí en el futuro (ej. TipoMembresiaSeeder::class)
        ]);
    }
}