<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\TipoMembresia;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use App\Models\ClienteMembresia;
use Carbon\Carbon;
use App\Models\Pago;

class ClientManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Cliente::query();

        // Aplica el filtro de búsqueda si existe
        $query->when($request->input('search'), function ($q, $search) {
            return $q->where('nombre', 'like', "%{$search}%")
                ->orWhere('correo', 'like', "%{$search}%");
        });

        $clients = $query->latest()->paginate(10);

        return view('admin.clients.index', compact('clients'));
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

        return redirect()->route('admin.clients.show', $client->id_cliente)
            ->with('success', '¡Cliente creado! Ahora puedes asignarle una membresía.');
    }

    // ===== INICIO DE LA MODIFICACIÓN =====
    public function show(Cliente $cliente)
    {
        // Carga todas las relaciones necesarias para el perfil completo del cliente
        $cliente->load([
            'clienteMembresias.tipoMembresia',
            'clienteMembresias.pagos',
            'asistencias',
            'asignacionesRutina.rutina.entrenador' // <-- AÑADIDO: Carga las asignaciones, la rutina y el entrenador que la creó
        ]);

        return view('admin.clients.show', compact('cliente'));
    }
    // ===== FIN DE LA MODIFICACIÓN =====

    public function createMembership(Cliente $cliente)
    {
        $tiposMembresia = TipoMembresia::where('estado', 'activo')->get();
        return view('admin.clients.assign_membership', compact('cliente', 'tiposMembresia'));
    }

    public function storeMembership(Request $request, Cliente $cliente)
    {
        $validatedData = $request->validate([
            'id_tipo_membresia' => 'required|integer|exists:Tipo_Membresia,id_tipo_membresia',
            'fecha_inicio' => 'required|date',
        ]);

        $tipoMembresia = TipoMembresia::find($validatedData['id_tipo_membresia']);
        $fechaInicio = Carbon::parse($validatedData['fecha_inicio']);
        $fechaFin = $fechaInicio->copy()->addDays($tipoMembresia->duracion_dias);

        $nuevaMembresia = ClienteMembresia::create([
            'id_cliente' => $cliente->id_cliente,
            'id_tipo_membresia' => $tipoMembresia->id_tipo_membresia,
            'fecha_inicio' => $validatedData['fecha_inicio'],
            'fecha_fin' => $fechaFin,
            'estado' => 'activa',
        ]);

        Pago::create([
            'id_cliente_membresia' => $nuevaMembresia->id_cliente_membresia,
            'fecha_pago' => Carbon::now(),
            'monto' => $tipoMembresia->precio,
            'metodo_pago' => 'Efectivo',
            'estado' => 'Completado',
        ]);

        return redirect()->route('admin.clients.show', $cliente->id_cliente)
            ->with('success', '¡Membresía "' . $tipoMembresia->nombre . '" asignada y pago registrado exitosamente!');
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

    public function destroy(Cliente $cliente)
    {
        try {
            $cliente->delete();
            return redirect()->route('admin.clients.index')
                ->with('success', '¡Cliente eliminado exitosamente!');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                return redirect()->route('admin.clients.index')
                    ->with('error', 'No se pudo eliminar el cliente. Es posible que tenga datos asociados.');
            }
            return redirect()->route('admin.clients.index')
                ->with('error', 'Error al eliminar el cliente: ' . $e->getMessage());
        }
    }
}