<?php

namespace App\Livewire\Clientes;

use Livewire\Component;
use App\Models\Cliente;

class EditCliente extends Component
{
    public Cliente $cliente;

    public $nombres;
    public $apellidos;
    public $tipo_documento;
    public $numero_documento;
    public $telefono;
    public $email;
    public $direccion;
    public $pais;

    public function mount(Cliente $cliente)
    {
        $this->cliente = $cliente;

        $this->nombres = $cliente->nombres;
        $this->apellidos = $cliente->apellidos;
        $this->tipo_documento = $cliente->tipo_documento;
        $this->numero_documento = $cliente->numero_documento;
        $this->telefono = $cliente->telefono;
        $this->email = $cliente->email;
        $this->direccion = $cliente->direccion;
        $this->pais = $cliente->pais;
    }

    public function actualizar()
    {
        $this->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'numero_documento' => 'required'
        ]);

        $this->cliente->update([
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'tipo_documento' => $this->tipo_documento,
            'numero_documento' => $this->numero_documento,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'direccion' => $this->direccion,
            'pais' => $this->pais,
        ]);

        session()->flash('mensaje', 'Cliente actualizado correctamente');
    }


    
    public function render()
    {
        return view('livewire.clientes.edit-cliente');
    }
}