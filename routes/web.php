<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\HabitacionController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\TipoHabitacionController;
use App\Livewire\Dashboard;
use App\Livewire\Recepcion\HabitacionOcupada;
use App\Livewire\Recepcion\ListarRegistrosOcupaciones;
use App\Livewire\Recepcion\ListRecepcion;
use App\Livewire\Recepcion\RegistrarIngresoHabitacion;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::resource('empleados', EmpleadoController::class);

    Route::resource('tipos-habitacion', TipoHabitacionController::class);
    Route::resource('habitaciones', HabitacionController::class);
    Route::resource('reservas', ReservasController::class);

    Route::resource('clientes', ClienteController::class);

    Route::get('/list-recepcion', ListRecepcion::class)->name('list-recepcion');
    Route::get('/recepcion/{id}/registrar_ingreso', RegistrarIngresoHabitacion::class)->name('registrar_ingreso_habitacion');
    Route::get('/habitacion-ocupada/{id}', HabitacionOcupada::class)
        ->name('habitacion_ocupada');

    Route::get('/list-registros-ocupaciones', ListarRegistrosOcupaciones::class)
        ->name('list-registros-ocupaciones');

    Route::resource('pagos', PagosController::class);

});
