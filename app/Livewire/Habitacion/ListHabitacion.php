<?php

namespace App\Livewire\Habitacion;

use App\Models\Habitacion;
use App\Models\TipoHabitacion;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ListHabitacion extends Component
{
    use WithFileUploads;

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

    // -------------------------------------------------------------------------
    // Validación
    // -------------------------------------------------------------------------
    protected function rules()
    {
        return [
            'numero' => 'required|string|unique:habitaciones,numero'.($this->habitacion_id ? ",{$this->habitacion_id},id_habitacion" : ''),
            'piso' => 'required|integer|min:1',
            'tipo' => 'required|exists:tipos_habitacion,id_tipo',
            'precio_base' => 'required|numeric|min:0',
            'estado' => 'required|in:disponible,ocupada,limpieza,mantenimiento',
            'observaciones' => 'nullable|string|max:500',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];
    }

    protected $messages = [
        'numero.required' => 'El número de habitación es obligatorio.',
        'numero.unique' => 'Ya existe una habitación con ese número.',
        'piso.required' => 'El piso es obligatorio.',
        'piso.min' => 'El piso debe ser mayor a 0.',
        'tipo.required' => 'Debes seleccionar un tipo de habitación.',
        'tipo.exists' => 'El tipo seleccionado no es válido.',
        'precio_base.required' => 'El precio es obligatorio.',
        'precio_base.min' => 'El precio no puede ser negativo.',
        'estado.required' => 'El estado es obligatorio.',
        'estado.in' => 'El estado seleccionado no es válido.',
        'imagen.image' => 'El archivo debe ser una imagen.',
        'imagen.mimes' => 'Solo se aceptan formatos JPG, PNG o WEBP.',
        'imagen.max' => 'La imagen no puede superar los 2 MB.',
    ];

    // -------------------------------------------------------------------------
    // CRUD
    // -------------------------------------------------------------------------
    public function crear()
    {
        $this->resetForm();
        $this->modo = 'crear';
        $this->open = true;
    }

    public function editar($id)
    {
        $hab = Habitacion::findOrFail($id);

        $this->habitacion_id = $hab->id_habitacion;
        $this->numero = $hab->numero;
        $this->piso = $hab->piso;
        $this->tipo = $hab->id_tipo;
        $this->precio_base = $hab->precio_base;
        $this->estado = $hab->estado;
        $this->observaciones = $hab->observaciones;
        $this->imagen_actual = $hab->imagen;   // ruta guardada en BD
        $this->imagen = null;
        $this->eliminar_imagen = false;

        $this->modo = 'editar';
        $this->open = true;
    }

    public function guardar()
    {
        $this->validate();

        $rutaImagen = $this->imagen_actual;

        if ($this->eliminar_imagen) {
            if ($rutaImagen && Storage::disk('public')->exists($rutaImagen)) {
                Storage::disk('public')->delete($rutaImagen);
            }
            $rutaImagen = null;
        }

        if ($this->imagen) {
            if ($rutaImagen && Storage::disk('public')->exists($rutaImagen)) {
                Storage::disk('public')->delete($rutaImagen);
            }
            $rutaImagen = $this->imagen->store('habitaciones', 'public');
        }
        // ────────────────────────────────────────────────────────────────────

        $datos = [
            'numero' => $this->numero,
            'piso' => $this->piso,
            'id_tipo' => $this->tipo,
            'precio_base' => $this->precio_base,
            'estado' => $this->estado,
            'observaciones' => $this->observaciones,
            'imagen' => $rutaImagen,
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
        $hab = Habitacion::findOrFail($id);

        // Eliminar imagen asociada si existe
        if ($hab->imagen && Storage::disk('public')->exists($hab->imagen)) {
            Storage::disk('public')->delete($hab->imagen);
        }

        $hab->delete();
        session()->flash('mensaje', 'Habitación eliminada correctamente.');
    }

    // -------------------------------------------------------------------------
    // Watchers
    // -------------------------------------------------------------------------

    /** Al seleccionar un tipo de habitación, auto-rellena el precio base. */
    public function updatedTipo($value)
    {
        $tipo = TipoHabitacion::where('id_tipo', $value)->first();
        if ($tipo) {
            $this->precio_base = $tipo->precio_base;
        }
    }

    /** Cuando el usuario marca "eliminar imagen", descarta cualquier nueva imagen seleccionada. */
    public function updatedEliminarImagen($value)
    {
        if ($value) {
            $this->imagen = null;
        }
    }

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------
    public function limpiarFiltros()
    {
        $this->buscar = '';
        $this->filtro_estado = '';
        $this->filtro_piso = '';
        $this->filtro_tipo = '';
    }

    private function resetForm()
    {
        $this->habitacion_id = null;
        $this->numero = '';
        $this->piso = '';
        $this->tipo = '';
        $this->precio_base = '';
        $this->estado = 'disponible';
        $this->observaciones = '';
        $this->imagen = null;
        $this->imagen_actual = null;
        $this->eliminar_imagen = false;
        $this->resetErrorBag();
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

        return view('livewire.habitacion.list-habitacion', compact('habitaciones'));
    }
}
