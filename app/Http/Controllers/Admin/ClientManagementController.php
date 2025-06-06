<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente; // Asegúrate de importar el modelo Cliente
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ClientManagementController extends Controller
{
    public function index()
    {
        $clients = Cliente::all();
        return view('admin.clients.index', ['clients' => $clients]);
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:150',
            'edad' => 'nullable|integer|min:1|max:120',
            'genero' => 'nullable|string|max:50',
            'correo' => 'required|string|email|max:255|unique:Cliente,correo',
            'telefono' => 'nullable|string|max:30',
            'password' => ['required', 'string', 'confirmed', Password::min(8)],
        ]);

        $client = Cliente::create([
            'nombre' => $validatedData['nombre'],
            'edad' => $validatedData['edad'],
            'genero' => $validatedData['genero'],
            'correo' => $validatedData['correo'],
            'telefono' => $validatedData['telefono'],
            'password' => Hash::make($validatedData['password']),
        ]);

        $client->assignRole('cliente');

        return redirect()->route('admin.clients.index')
            ->with('success', '¡Cliente creado exitosamente!');
    }

    public function edit(Cliente $cliente)
    {
        return view('admin.clients.edit', ['client' => $cliente]);
    }

    public function update(Request $request, Cliente $cliente)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:150',
            'edad' => 'nullable|integer|min:1|max:120',
            'genero' => 'nullable|string|max:50',
            'correo' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('Cliente', 'correo')->ignore($cliente->id_cliente, 'id_cliente')
            ],
            'telefono' => 'nullable|string|max:30',
            'password' => ['nullable', 'string', 'confirmed', Password::min(8)],
        ]);

        $updateData = [
            'nombre' => $validatedData['nombre'],
            'edad' => $validatedData['edad'],
            'genero' => $validatedData['genero'],
            'correo' => $validatedData['correo'],
            'telefono' => $validatedData['telefono'],
        ];

        if (!empty($validatedData['password'])) {
            $updateData['password'] = Hash::make($validatedData['password']);
        }

        $cliente->update($updateData);

        return redirect()->route('admin.clients.index')
            ->with('success', '¡Cliente actualizado exitosamente!');
    }

    /**
     * Elimina un cliente específico de la base de datos.
     *
     * @param  \App\Models\Cliente  $cliente // Route Model Binding
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Cliente $cliente)
    {
        try {
            // Consideraciones: ¿El cliente tiene membresías activas, pagos, reservas, etc.?
            // La configuración de tus claves foráneas (ON DELETE RESTRICT, CASCADE, SET NULL)
            // determinará qué sucede. Si usas RESTRICT, la eliminación fallará si hay datos asociados.

            $cliente->delete();

            return redirect()->route('admin.clients.index')
                ->with('success', '¡Cliente eliminado exitosamente!');
        } catch (\Illuminate\Database\QueryException $e) {
            // Capturar excepciones de consulta, comúnmente por restricciones de clave foránea
            if ($e->getCode() === '23000' || str_contains($e->getMessage(), 'constraint violation')) {
                return redirect()->route('admin.clients.index')
                    ->with('error', 'No se pudo eliminar el cliente. Es posible que tenga datos asociados (membresías, pagos, reservas, etc.).');
            }
            // Para otros errores de base de datos
            return redirect()->route('admin.clients.index')
                ->with('error', 'Error al eliminar el cliente: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Capturar cualquier otra excepción general
            return redirect()->route('admin.clients.index')
                ->with('error', 'Ocurrió un error inesperado al intentar eliminar el cliente: ' . $e->getMessage());
        }
    }
}