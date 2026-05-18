<?php

namespace App\Livewire\Reservas;

use App\Models\Cliente;
use App\Models\Habitacion;
use App\Models\Reservas;
use Livewire\Component;

class ListReservas extends Component
{
    // Modal
    public $open = false;

    // Campos del formulario
    public $id_cliente;

    public $fecha_ingreso;

    public $fecha_salida;

    public $id_habitacion;

    public $numero_huespedes;

    public $adelanto;

    public $notas;

    public function eliminar_reserva($id)
    {
        $reserva = Reservas::findOrFail($id);
        $reserva->delete();
    }

    // MARCAR SALIDA DEL HUESPED
    public function check_in($id)
    {
        $reserva = Reservas::findOrFail($id);

        $reserva->estado = 2;
        $reserva->save();
    }

    protected $messages = [
        'id_cliente.required' => 'Seleccione un cliente.',
        'id_cliente.exists' => 'El cliente no es válido.',
        'fecha_ingreso.required' => 'La fecha de ingreso es obligatoria.',
        'fecha_salida.required' => 'La fecha de salida es obligatoria.',
        'fecha_salida.after' => 'La fecha de salida debe ser posterior al ingreso.',
        'id_habitacion.required' => 'Seleccione una habitación.',
        'numero_huespedes.required' => 'Ingrese el número de huéspedes.',
        'numero_huespedes.min' => 'Debe haber al menos 1 huésped.',
        'adelanto.numeric' => 'El adelanto debe ser un número.',
    ];

    protected function rules()
    {
        return [
            'id_cliente' => 'required|exists:clientes,id_cliente',
            'fecha_ingreso' => 'required|date',
            'fecha_salida' => 'required|date|after:fecha_ingreso',
            'id_habitacion' => 'required|exists:habitaciones,id_habitacion',
            'numero_huespedes' => 'required|integer|min:1',
            'adelanto' => 'nullable|numeric|min:0',
            'notas' => 'nullable|string|max:500',
        ];
    }

    public function guardar()
    {
        $this->validate();

        Reservas::create([
            'id_cliente' => $this->id_cliente,
            'fecha_ingreso' => $this->fecha_ingreso,
            'fecha_salida' => $this->fecha_salida,
            'id_habitacion' => $this->id_habitacion,
            'numero_huespedes' => $this->numero_huespedes,
            'adelanto' => $this->adelanto ?? 0,
            'notas' => $this->notas,
            'estado' => 1, // Pendiente por defecto
        ]);

        $this->reset([
            'id_cliente', 'fecha_ingreso', 'fecha_salida',
            'id_habitacion', 'numero_huespedes', 'adelanto', 'notas',
        ]);

        $this->open = false;

        session()->flash('mensaje', 'Reserva registrada correctamente.');
    }

    public function crear()
    {
        // $this->resetForm();
        $this->modo = 'crear';
        $this->open = true;
    }

    public function render()
    {
        // Cargar clientes y habitaciones para los select
        $clientes = Cliente::all();
        $habitaciones = Habitacion::all();
        $reservas = Reservas::all();

        return view('livewire.reservas.list-reservas', [
            'clientes' => $clientes,
            'habitaciones' => $habitaciones,
            'reservas' => $reservas,
        ]);
    }
}
