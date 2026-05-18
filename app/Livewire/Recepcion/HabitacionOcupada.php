<?php

namespace App\Livewire\Recepcion;

use App\Models\Estancia;
use App\Models\Habitacion;
use App\Models\Pagos;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class HabitacionOcupada extends Component
{
    public $idHabitacion;

    public $habitacion;

    public $estancia;

    // Pago
    public $metodo_pago = 'efectivo';

    public $monto_pago = 0;

    public $referencia = '';

    public $observaciones = '';

    // Calculados
    public $total_estancia = 0;

    public $total_pagado = 0;

    public $saldo_pendiente = 0;

    // Confirmación modal
    public $mostrarModalConfirmar = false;

    // ──────────────────────────────────────────────
    public function mount($id)
    {
        $this->idHabitacion = $id;
        $this->habitacion = Habitacion::with('tipoHabitacion')->findOrFail($id);

        // Buscar la estancia activa (ocupada) más reciente
        $this->estancia = Estancia::where('habitacion_id', $id)
            ->whereIn('estado', ['pending', 'partial', 'paid'])
            ->latest()
            ->firstOrFail();

        $this->calcular();
    }

    public function calcular()
    {
        $this->total_estancia = (float) $this->estancia->total;

        // Suma de pagos ya registrados
        $this->total_pagado = (float) Pagos::where('estancia_id', $this->estancia->id)
            ->where('estado', 'completado')
            ->sum('monto');

        $this->saldo_pendiente = max(0, $this->total_estancia - $this->total_pagado);

        // Pre-cargar el monto con el saldo pendiente
        $this->monto_pago = $this->saldo_pendiente;
    }

    public function updated($field)
    {
        if ($field === 'monto_pago') {
            // No recalcular total, solo validar rango
            $this->monto_pago = min(
                max(0, (float) $this->monto_pago),
                $this->saldo_pendiente
            );
        }
    }

    // ──────────────────────────────────────────────
    // ABRIR / CERRAR MODAL
    // ──────────────────────────────────────────────
    public function abrirModalConfirmar()
    {
        $this->validate([
            'metodo_pago' => 'required|in:efectivo,tarjeta,transferencia,yape,plin,otro',
            'monto_pago' => 'required|numeric|min:0',
        ]);

        $this->mostrarModalConfirmar = true;
    }

    public function cerrarModalConfirmar()
    {
        $this->mostrarModalConfirmar = false;
    }

    // ──────────────────────────────────────────────
    // COBRAR Y PASAR A LIMPIEZA
    // ──────────────────────────────────────────────
    public function cobrarYLimpiar()
    {
        $this->validate([
            'metodo_pago' => 'required|in:efectivo,tarjeta,transferencia,yape,plin,otro',
            'monto_pago' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () {
            // 1. Registrar pago si hay monto
            if ((float) $this->monto_pago > 0) {
                Pagos::create([
                    'estancia_id' => $this->estancia->id,
                    'monto' => (float) $this->monto_pago,
                    'metodo_pago' => $this->metodo_pago,
                    'tipo' => 'checkout',
                    'estado' => 'completado',
                    'referencia' => $this->referencia ?: null,
                    'fecha_pago' => now(),
                    'observaciones' => $this->observaciones ?: null,
                    'user_id' => Auth::id(),
                ]);
            }

            // 2. Cerrar la estancia → checkout
            $this->estancia->update([
                'estado' => 'checkout',
                'fecha_checkout' => now()->format('Y-m-d'),
            ]);

            // 3. Habitación → limpieza
            $this->habitacion->update(['estado' => 'limpieza']);
        });

        session()->flash('success', 'Check-out registrado. La habitación está en modo Limpieza.');
        $this->redirect(route('habitaciones.index'));
    }

    // ──────────────────────────────────────────────
    public function render()
    {
        // Historial de pagos de esta estancia
        $pagos = Pagos::where('estancia_id', $this->estancia->id)
            ->orderBy('fecha_pago')
            ->get();

        return view('livewire.recepcion.habitacion-ocupada', compact('pagos'))
            ->layout('layouts.app');
    }
}
