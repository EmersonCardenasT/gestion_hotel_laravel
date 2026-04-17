<?php

namespace App\Livewire;
use Illuminate\Support\Facades\Http;
use App\Models\TipoHabitacion;
use Livewire\Component;

class TipoHabitacionModal extends Component
{

    protected $listeners = ['editarTipo' => 'editar'];

    public $open = false;
    public $modo = 'crear';
    public $tipo_id = null;

    public $nombre;
    public $descripcion;
    public $capacidad;
    public $precio_base;
    public $comodidades;
    public $activo = true;

    public function updatedOpen($value)
    {
        if (!$value) {
            $this->resetCampos();
        }
    }

    public function crear()
    {
        $this->resetCampos();
        $this->modo = 'crear';
        $this->open = true;
    }

    public function guardar()
    {
        if ($this->modo === 'crear') {
            
            $tipo = TipoHabitacion::create([
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'capacidad' => $this->capacidad,
                'precio_base' => $this->precio_base,
                'comodidades' => $this->comodidades,
                'activo' => $this->activo,
            ]);
            

        } else {

            $tipo = TipoHabitacion::find($this->tipo_id);

            $tipo->update([
                'nombre' => $this->nombre,
                'descripcion' => $this->descripcion,
                'capacidad' => $this->capacidad,
                'precio_base' => $this->precio_base,
                'comodidades' => $this->comodidades,
                'activo' => $this->activo,
            ]);

        }

        $this->dispatch('tipoHabitacionCreada');

        $this->resetCampos();
        $this->open = false;
    }

    public function editar($id)
    {
        $tipo = TipoHabitacion::find($id);

        $this->tipo_id = $tipo->id_tipo;
        $this->nombre = $tipo->nombre;
        $this->descripcion = $tipo->descripcion;
        $this->capacidad = $tipo->capacidad;
        $this->precio_base = $tipo->precio_base;
        $this->comodidades = $tipo->comodidades;
        $this->activo = $tipo->activo;

        $this->modo = 'editar';
        $this->open = true;
    }

    public function resetCampos()
    {
        $this->reset([
            'tipo_id',
            'nombre',
            'descripcion',
            'capacidad',
            'precio_base',
            'comodidades'
        ]);

        $this->activo = true;
        $this->modo = 'crear';
    }

    public function render()
    {
        return view('livewire.tipo-habitacion-modal');
    }
}
