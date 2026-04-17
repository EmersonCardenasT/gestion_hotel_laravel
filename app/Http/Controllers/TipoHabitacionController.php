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
    
}
