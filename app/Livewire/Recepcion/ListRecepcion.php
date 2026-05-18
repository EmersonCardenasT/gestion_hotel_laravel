<?php

namespace App\Livewire\Recepcion;

use App\Models\Habitacion;
use App\Models\TipoHabitacion;
use Livewire\Component;

class ListRecepcion extends Component
{
    public $open = false;

    public $habitacionId;

    public $mensajeConfirmacion;

    // Imagen
    public $imagen = null;           // archivo subido (Livewire temporal)

    public $imagen_actual = null;    // ruta guardada en BD (para mostrar preview al editar)

    public $eliminar_imagen = false; // checkbox para quitar la imagen existente

    // Filtros
    public $buscar = '';

    public $filtro_estado = '';

    public $filtro_piso = '';

    public $filtro_tipo = '';

    // Data
    public $tipo_habitacion = [];

    public $pisos_disponibles = [];

    public $tipos_para_filtro = [];

    // METODO PARA CAMBIAR A DISPONIBLE
    public function cambiarADisponible()
    {
        $hab = Habitacion::findOrFail($this->habitacionId);

        $hab->estado = 'disponible';
        $hab->save();

        $this->open = false;
    }

    // REDIRIGIR O SOLTAR ACCION DEPENDIENDO EL ESTADO
    public function verificarHabitacion($id, $estado)
    {
        if ($estado === 'disponible') {
            return redirect()->route('registrar_ingreso_habitacion', $id);
        }

        if ($estado === 'ocupada') {
            return redirect()->route('habitacion_ocupada', $id);
        }

        if ($estado === 'limpieza') {
            $this->habitacionId = $id;
            $this->mensajeConfirmacion = 'La habitación está en limpieza ¿cambiar a disponible?';
            $this->open = true;
        }

        if ($estado === 'mantenimiento') {
            $this->habitacionId = $id;
            $this->mensajeConfirmacion = 'La habitación está en mantenimiento ¿cambiar a disponible?';
            $this->open = true;
        }
    }

    public function limpiarFiltros()
    {
        $this->buscar = '';
        $this->filtro_estado = '';
        $this->filtro_piso = '';
        $this->filtro_tipo = '';
    }

    public function render()
    {
        $this->tipo_habitacion = TipoHabitacion::where('activo', 1)->get();
        $this->tipos_para_filtro = TipoHabitacion::orderBy('nombre')->get();
        $this->pisos_disponibles = Habitacion::distinct()->orderBy('piso')->pluck('piso');
        $habitaciones = Habitacion::with('tipoHabitacion')
            ->when($this->buscar, fn ($q) => $q->where(fn ($q2) => $q2->where('numero', 'like', "%{$this->buscar}%")
                ->orWhere('piso', 'like', "%{$this->buscar}%")
            )
            )
            ->when($this->filtro_estado, fn ($q) => $q->where('estado', $this->filtro_estado))
            ->when($this->filtro_piso, fn ($q) => $q->where('piso', $this->filtro_piso))
            ->when($this->filtro_tipo, fn ($q) => $q->where('id_tipo', $this->filtro_tipo))
            ->orderBy('piso')
            ->orderBy('numero')
            ->get();

        return view('livewire.recepcion.list-recepcion', compact('habitaciones'))
            ->layout('layouts.app');
    }
}
