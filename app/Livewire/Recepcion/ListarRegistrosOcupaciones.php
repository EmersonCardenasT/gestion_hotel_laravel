<?php

namespace App\Livewire\Recepcion;

use App\Models\Estancia;
use Livewire\Component;
use Livewire\WithPagination;

class ListarRegistrosOcupaciones extends Component
{
    use WithPagination;

    public $search = '';

    public $estadoFiltro = '';

    public $modalVer = false;

    public $estanciaSeleccionada = null;

    public $confirmarEliminar = false;

    public $estanciaEliminarId = null;

    protected $queryString = [
        'search' => ['except' => ''],
        'estadoFiltro' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingEstadoFiltro()
    {
        $this->resetPage();
    }

    public function verDetalle($id)
    {
        $this->estanciaSeleccionada = Estancia::withTrashed()->with(['cliente', 'habitacion', 'reserva'])->findOrFail($id);
        $this->modalVer = true;
    }

    public function cerrarModal()
    {
        $this->modalVer = false;
        $this->estanciaSeleccionada = null;
    }

    public function confirmarEliminacion($id)
    {
        $this->estanciaEliminarId = $id;
        $this->confirmarEliminar = true;
    }

    public function cancelarEliminacion()
    {
        $this->confirmarEliminar = false;
        $this->estanciaEliminarId = null;
    }

    public function eliminar()
    {
        $estancia = Estancia::findOrFail($this->estanciaEliminarId);
        $estancia->delete(); // SoftDelete

        $this->confirmarEliminar = false;
        $this->estanciaEliminarId = null;

        session()->flash('success', 'Registro de ocupación eliminado correctamente.');
    }

    public function render()
    {
        $estancias = Estancia::with(['cliente', 'habitacion'])
            ->when($this->search, function ($query) {
                $query->whereHas('cliente', function ($q) {
                    $q->where('nombre', 'like', '%'.$this->search.'%')
                        ->orWhere('apellido', 'like', '%'.$this->search.'%')
                        ->orWhere('dni', 'like', '%'.$this->search.'%');
                })->orWhereHas('habitacion', function ($q) {
                    $q->where('numero', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->estadoFiltro, function ($query) {
                $query->where('estado', $this->estadoFiltro);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.recepcion.listar-registros-ocupaciones', compact('estancias'))
            ->layout('layouts.app');
    }
}
