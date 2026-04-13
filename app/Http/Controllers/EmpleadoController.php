<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request('search');

        $empleados = Empleado::when($search, function ($query, $search) {
            $query->where('nombre', 'like', "%{$search}%")
                ->orWhere('apellido', 'like', "%{$search}%")
                ->orWhere('dni', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('pages.empleados.list', compact('empleados'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.empleados.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|max:20|unique:empleados,dni',
            'email' => 'required|email|max:255|unique:empleados,email',
            'telefono' => 'nullable|string|max:20',
            'fecha_ingreso' => 'required|date',
            'direccion' => 'nullable|string|max:255',
        ]);

        $registro = Empleado::create($request->all());

        if ($registro) {
            return response()->json([
                'success' => true,
                'message' => 'Empleado registrado correctamente'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Error al registrar'
        ], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        // return view ('pages.empleados.show', compact('empleado'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empleado $empleado)
    {
        return view('pages.empleados.edit', compact('empleado'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empleado $empleado)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|max:20|unique:empleados,dni,' . $empleado->id,
            'email' => 'required|email|max:255|unique:empleados,email,' . $empleado->id,
            'telefono' => 'nullable|string|max:20',
            'fecha_ingreso' => 'required|date',
            'direccion' => 'nullable|string|max:255',
        ]);

        $update = $empleado->update($request->all());

        if ($update) {
            return response()->json([
                'success' => true,
                'message' => 'Empleado actualizado correctamente'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Error al actualizar'
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empleado $empleado)
    {
        if ($empleado->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Empleado eliminado'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Error al eliminar'
        ], 500);
    }
}
