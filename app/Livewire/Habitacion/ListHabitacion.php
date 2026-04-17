<?php

namespace App\Livewire\Habitacion;

use Livewire\Component;
use App\Models\Habitacion;
use App\Models\TipoHabitacion;

class ListHabitacion extends Component
{
    // Modal
    public $open = false;
    public $modo = 'crear';
    public $habitacion_id = null;

    // Campos
    public $numero = '';
    public $piso = '';
    public $tipo = '';
    public $precio_base = '';
    public $estado = 'disponible';
    public $observaciones = '';

    // Filtros
    public $buscar = '';
    public $filtro_estado = '';

    // Data
    public $tipo_habitacion = [];

    // Validación
    protected function rules()
    {
        return [
            'numero'        => 'required|string|unique:habitaciones,numero' . ($this->habitacion_id ? ",{$this->habitacion_id},id_habitacion" : ''),
            'piso'          => 'required|integer|min:1',
            'tipo'          => 'required|exists:tipos_habitacion,id_tipo',
            'precio_base'   => 'required|numeric|min:0',
            'estado'        => 'required|in:disponible,ocupada,limpieza,mantenimiento',
            'observaciones' => 'nullable|string|max:500',
        ];
    }

    protected $messages = [
        'numero.required'      => 'El número de habitación es obligatorio.',
        'numero.unique'        => 'Ya existe una habitación con ese número.',
        'piso.required'        => 'El piso es obligatorio.',
        'piso.min'             => 'El piso debe ser mayor a 0.',
        'tipo.required'        => 'Debes seleccionar un tipo de habitación.',
        'tipo.exists'          => 'El tipo seleccionado no es válido.',
        'precio_base.required' => 'El precio es obligatorio.',
        'precio_base.min'      => 'El precio no puede ser negativo.',
        'estado.required'      => 'El estado es obligatorio.',
        'estado.in'            => 'El estado seleccionado no es válido.',
    ];

    public function crear()
    {
        $this->resetForm();
        $this->modo = 'crear';
        $this->open = true;
    }

    public function editar($id)
    {
        $hab = Habitacion::findOrFail($id);

        $this->habitacion_id  = $hab->id_habitacion;
        $this->numero         = $hab->numero;
        $this->piso           = $hab->piso;
        $this->tipo           = $hab->id_tipo;
        $this->precio_base    = $hab->precio_base;
        $this->estado         = $hab->estado;
        $this->observaciones  = $hab->observaciones;

        $this->modo = 'editar';
        $this->open = true;
    }

    public function guardar()
    {
        $this->validate();

        $datos = [
            'numero'       => $this->numero,
            'piso'         => $this->piso,
            'id_tipo'      => $this->tipo,
            'precio_base'  => $this->precio_base,
            'estado'       => $this->estado,
            'observaciones'=> $this->observaciones,
        ];

        if ($this->modo === 'crear') {
            Habitacion::create($datos);
            session()->flash('mensaje', 'Habitación creada correctamente.');
        } else {
            Habitacion::where('id_habitacion', $this->habitacion_id)->update($datos);
            session()->flash('mensaje', 'Habitación actualizada correctamente.');
        }

        $this->resetForm();
        $this->open = false;
    }

    public function eliminar($id)
    {
        Habitacion::findOrFail($id)->delete();
        session()->flash('mensaje', 'Habitación eliminada correctamente.');
    }

    // Actualiza el precio al seleccionar tipo
    public function updatedTipo($value)
    {
        $tipo = TipoHabitacion::where('id_tipo', $value)->first();
        if ($tipo) {
            $this->precio_base = $tipo->precio_base;
        }
    }

    private function resetForm()
    {
        $this->habitacion_id = null;
        $this->numero        = '';
        $this->piso          = '';
        $this->tipo          = '';
        $this->precio_base   = '';
        $this->estado        = 'disponible';
        $this->observaciones = '';
        $this->resetErrorBag();
    }

    public function render()
    {
        $this->tipo_habitacion = TipoHabitacion::where('activo', 1)->get();

        $habitaciones = Habitacion::with('tipoHabitacion')
            ->when($this->buscar, fn($q) => $q->where('numero', 'like', "%{$this->buscar}%"))
            ->when($this->filtro_estado, fn($q) => $q->where('estado', $this->filtro_estado))
            ->orderBy('piso')
            ->orderBy('numero')
            ->get();

        return view('livewire.habitacion.list-habitacion', compact('habitaciones'));
    }
}