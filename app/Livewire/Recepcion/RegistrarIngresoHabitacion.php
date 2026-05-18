<?php

namespace App\Livewire\Recepcion;

use App\Models\Cliente;
use App\Models\Estancia;
use App\Models\Habitacion;
use App\Models\Pagos;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RegistrarIngresoHabitacion extends Component
{
    // Habitación
    public $habitacion;

    public $precio_noche;

    // Detalle reserva
    public $id_cliente = '';

    public $fecha_ingreso;

    public $cantidad_noches = 1;

    public $cantidad_adultos = 1;

    public $cantidad_ninos = 0;

    public $observaciones = '';

    // Extender estancia (modal)
    public $mostrarModalExtender = false;

    public $noches_extra = 1;

    // Estado del huésped / habitación
    // pending | partial | paid | checkout | cancelled
    public $estado_pago = 'pending';

    // Pago
    public $metodo_pago = 'efectivo';

    public $monto_adelanto = 0;

    public $referencia = '';

    // Calculados
    public $subtotal = 0;

    public $saldo = 0;

    // ──────────────────────────────────────────────
    public function mount($id)
    {
        $this->habitacion = Habitacion::with('tipoHabitacion')->findOrFail($id);
        $this->precio_noche = $this->habitacion->precio_base;
        $this->fecha_ingreso = now()->format('Y-m-d');
        $this->calcular();
    }

    // Recalcula cada vez que cambia cualquier propiedad
    public function updated($field)
    {
        if (in_array($field, ['cantidad_noches', 'monto_adelanto', 'estado_pago'])) {
            $this->calcular();
        }
    }

    public function calcular()
    {
        $this->cantidad_noches = max(1, (int) $this->cantidad_noches);
        $this->subtotal = $this->precio_noche * $this->cantidad_noches;

        // Si el estado es "pagado completo" forzamos adelanto = total
        if ($this->estado_pago === 'paid') {
            $this->monto_adelanto = $this->subtotal;
        }

        // Si es "pendiente", sin adelanto
        if ($this->estado_pago === 'pending') {
            $this->monto_adelanto = 0;
        }

        $adelanto = min((float) $this->monto_adelanto, $this->subtotal);
        $this->saldo = $this->subtotal - $adelanto;
    }

    // ──────────────────────────────────────────────
    // GUARDAR
    // ──────────────────────────────────────────────
    public function guardar()
    {
        $this->validate([
            'id_cliente' => 'required|exists:clientes,id_cliente',
            'fecha_ingreso' => 'required|date',
            'cantidad_noches' => 'required|integer|min:1',
            'cantidad_adultos' => 'required|integer|min:1',
            'cantidad_ninos' => 'nullable|integer|min:0',
            'estado_pago' => 'required|in:pending,partial,paid,checkout,cancelled',
            'metodo_pago' => 'required|in:efectivo,tarjeta,transferencia,yape,plin,otro',
            'monto_adelanto' => 'nullable|numeric|min:0',
        ]);

        $this->calcular();

        DB::transaction(function () {
            $fechaCheckout = Carbon::parse($this->fecha_ingreso)
                ->addDays($this->cantidad_noches)
                ->format('Y-m-d');

            // 1. Crear estancia
            $estancia = Estancia::create([
                'cliente_id' => $this->id_cliente,
                'habitacion_id' => $this->habitacion->id_habitacion,
                'fecha_checkin' => $this->fecha_ingreso,
                'fecha_checkout' => $fechaCheckout,
                'adultos' => $this->cantidad_adultos,
                'ninos' => $this->cantidad_ninos ?? 0,
                'tarifa_noche' => $this->precio_noche,
                'noches' => $this->cantidad_noches,
                'subtotal' => $this->subtotal,
                'total' => $this->subtotal,
                'estado' => $this->estado_pago,
                'observaciones' => $this->observaciones,
            ]);

            // 2. Registrar pago si hay adelanto o pago completo
            $adelanto = (float) $this->monto_adelanto;
            if ($adelanto > 0) {
                Pagos::create([
                    'estancia_id' => $estancia->id,
                    'monto' => $adelanto,
                    'metodo_pago' => $this->metodo_pago,
                    'tipo' => $this->estado_pago === 'paid' ? 'total' : 'adelanto',
                    'estado' => 'completado',
                    'referencia' => $this->referencia ?: null,
                    'fecha_pago' => now(),
                    'observaciones' => $this->observaciones ?: null,
                    'user_id' => Auth::id(),
                ]);
            }

            // 3. Actualizar estado de la habitación
            $estadoHabitacion = match ($this->estado_pago) {
                'checkout', 'cancelled' => 'disponible',
                default => 'ocupada',
            };
            $this->habitacion->update(['estado' => $estadoHabitacion]);
        });

        session()->flash('success', 'Huésped registrado correctamente.');
        $this->redirect(route('habitaciones.index'));
    }

    // ──────────────────────────────────────────────
    // EXTENDER ESTANCIA (modal)
    // ──────────────────────────────────────────────
    public function abrirModalExtender()
    {
        $this->mostrarModalExtender = true;
        $this->noches_extra = 1;
    }

    public function cerrarModalExtender()
    {
        $this->mostrarModalExtender = false;
    }

    public function extenderEstancia()
    {
        $this->validate(['noches_extra' => 'required|integer|min:1|max:365']);
        $this->cantidad_noches += (int) $this->noches_extra;
        $this->calcular();
        $this->mostrarModalExtender = false;
    }

    // ──────────────────────────────────────────────
    public function render()
    {
        $clientes = Cliente::orderBy('apellidos')->get();

        return view('livewire.recepcion.registrar-ingreso-habitacion', compact('clientes'))
            ->layout('layouts.app');
    }
}
