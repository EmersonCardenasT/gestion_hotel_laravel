<?php

namespace App\Http\Controllers;

use App\Models\TipoHabitacion;
use Illuminate\Http\Request;

class TipoHabitacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipo_habitaciones = TipoHabitacion::orderBy('id_tipo', 'desc')->get();
        return view('pages.tipo-habitaciones.list', compact('tipo_habitaciones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $tipoHabitacion = TipoHabitacion::create($request->all());

        return response()->json([
            "message" => 200,
            "warehouse" => [
                "id_tipo" => $tipoHabitacion->id_tipo,
                "nombre" => $tipoHabitacion->nombre,
                "descripcion" => $tipoHabitacion->descripcion,
                "capacidad" => $tipoHabitacion->capacidad,
                "precio_base" => $tipoHabitacion->precio_base,
                "comodidades" => $tipoHabitacion->comodidades,
                "activo" => $tipoHabitacion->activo
            ]
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TipoHabitacion $tipoHabitacion)
    {
        $tipoHabitacion = TipoHabitacion::findOrFail($tipoHabitacion);
        $tipoHabitacion->update($request->all());

        return response()->json([
            "message" => 200,
            "warehouse" => [
                "id_tipo" => $tipoHabitacion->id_tipo,
                "nombre" => $tipoHabitacion->nombre,
                "descripcion" => $tipoHabitacion->descripcion,
                "capacidad" => $tipoHabitacion->capacidad,
                "precio_base" => $tipoHabitacion->precio_base,
                "comodidades" => $tipoHabitacion->comodidades,
                "activo" => $tipoHabitacion->activo
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoHabitacion $tipoHabitacion)
    {
        $tipoHabitacion = TipoHabitacion::findOrFail($tipoHabitacion);
        $tipoHabitacion->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Tipo de habitación eliminado correctamente.',
        ]);
    }
}
