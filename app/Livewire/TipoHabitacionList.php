<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TipoHabitacion;

class TipoHabitacionList extends Component
{

    public $tipo_habitaciones = [];
    
    protected $listeners = [
        'tipoHabitacionCreada' => 'cargar',
    ];

    public function mount()
    {
        $this->cargar();
    }

    public function cargar()
    {
        $this->tipo_habitaciones = TipoHabitacion::latest()->get();
    }


    public function eliminar($id)
    {
        // Usar findOrFail para evitar errores si el ID no existe
        $tipoh = TipoHabitacion::findOrFail($id);
        $tipoh->delete();

        // Refrescar la lista
        $this->cargar();

        // Opcional: Enviar una notificación de éxito después de borrar
        $this->dispatch('alert', ['message' => 'Tipo de eliminado con éxito']);
    }

    public function render()
    {
        return view('livewire.tipo-habitacion-list');
    }
}