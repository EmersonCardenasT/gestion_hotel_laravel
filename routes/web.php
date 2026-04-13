<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\TipoHabitacionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('empleados', EmpleadoController::class);

    Route::resource('habitaciones', HabitacionController::class);
    Route::resource('tipos-habitacion', TipoHabitacionController::class);
    Route::resource('clientes', ClienteController::class);
    Route::resource('reservas', ReservasController::class);
    Route::resource('pagos', PagosController::class);

});
