<?php

namespace App\Livewire\Clientes;

use Livewire\Component;
use App\Models\Cliente;

class CreateCliente extends Component
{

    public $nombres;
    public $apellidos;
    public $tipo_documento;
    public $numero_documento;
    public $telefono;
    public $email;
    public $direccion;
    public $pais = 'Perú';

    protected $rules = [
        'nombres' => 'required|string|max:255',
        'apellidos' => 'required|string|max:255',
        'tipo_documento' => 'nullable|string|max:50',
        'numero_documento' => 'required|string|max:50|unique:clientes,numero_documento',
        'telefono' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:255',
        'direccion' => 'nullable|string|max:255',
        'pais' => 'required|string|max:100',
    ];

    public function guardar()
    {
        $this->validate();

        Cliente::create([
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'tipo_documento' => $this->tipo_documento,
            'numero_documento' => $this->numero_documento,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'direccion' => $this->direccion,
            'pais' => $this->pais,
        ]);

        session()->flash('mensaje', 'Cliente registrado correctamente');
        $this->resetForm();
        // return $this->redirectRoute('clientes.index');
    }

    public function resetForm()
    {
        $this->nombres = '';
        $this->apellidos = '';
        $this->tipo_documento = '';
        $this->numero_documento = '';
        $this->telefono = '';
        $this->email = '';
        $this->direccion = '';
        $this->pais = 'Perú';
    }

    

    public function confirmarEliminar($id)
    {
        $this->dispatch('confirmar-eliminar', id: $id);
    }

    public function eliminar($id)
    {
        Cliente::find($id)?->delete();
    }   

    public function render()
    {
        return view('livewire.clientes.create-cliente');
    }
}
