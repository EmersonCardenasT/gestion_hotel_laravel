<?php

namespace App\Livewire\Clientes;

use Livewire\Attributes\On;
use App\Models\Cliente;
use Livewire\Component;
use Livewire\WithPagination;

class ListClientes extends Component
{
    use WithPagination;
    public $buscar = '';

    public function updatingBuscar()
    {
        $this->resetPage();
    }

    public function eliminar($id)   
    {
        Cliente::findOrFail($id)->delete();
        session()->flash('mensaje', 'Habitación eliminada correctamente.');
    }

    public function render()
    {
        $clientes = Cliente::query()
            ->where('nombres', 'like', "%{$this->buscar}%")
            ->orWhere('apellidos', 'like', "%{$this->buscar}%")
            ->orWhere('numero_documento', 'like', "%{$this->buscar}%")
            ->latest()
            ->paginate(15);

        return view('livewire.clientes.list-clientes', compact('clientes'));
    }
}
