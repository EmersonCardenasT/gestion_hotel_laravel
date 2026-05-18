<?php

namespace App\Livewire;

use App\Models\Cliente;
use App\Models\Estancia;
use App\Models\Habitacion;
use App\Models\Pagos;
use App\Models\Reservas;
use App\Models\TipoHabitacion;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $aiInsight = '';

    public $aiLoading = false;

    public $aiQuery = '';

    public $periodoGrafico = 'semana'; // semana, mes, año

    // ─── Métricas principales ───────────────────────────────────────────────

    public function getHabitacionesStatsProperty()
    {
        return [
            'total' => Habitacion::count(),
            'disponible' => Habitacion::where('estado', 'disponible')->count(),
            'ocupada' => Habitacion::where('estado', 'ocupada')->count(),
            'limpieza' => Habitacion::where('estado', 'limpieza')->count(),
            'cliente' => Cliente::count(),
            'mantenimiento' => Habitacion::where('estado', 'mantenimiento')->count(),
        ];
    }

    public function getIngresosMesProperty()
    {
        return Pagos::whereMonth('fecha_pago', Carbon::now()->month)
            ->whereYear('fecha_pago', Carbon::now()->year)
            ->where('estado', 'pagado')
            ->sum('monto') ?? 0;
    }

    public function getIngresosHoyProperty()
    {
        return Pagos::whereDate('fecha_pago', Carbon::today())
            ->where('estado', 'pagado')
            ->sum('monto') ?? 0;
    }

    public function getOcupacionPorcentajeProperty()
    {
        $total = Habitacion::count();
        if ($total === 0) {
            return 0;
        }
        $ocupadas = Habitacion::where('estado', 'ocupada')->count();

        return round(($ocupadas / $total) * 100);
    }

    public function getReservasPendientesProperty()
    {
        return Reservas::where('estado', 'pendiente')->count();
    }

    public function getEstanciasActivasProperty()
    {
        return Estancia::where('estado', 'activa')->count();
    }

    public function getCheckinsHoyProperty()
    {
        return Estancia::whereDate('fecha_checkin', Carbon::today())->count();
    }

    public function getCheckoutsHoyProperty()
    {
        return Estancia::whereDate('fecha_checkout', Carbon::today())->count();
    }

    public function getTotalClientesProperty()
    {
        return Cliente::count();
    }

    public function getClientesNuevosMesProperty()
    {
        return Cliente::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
    }

    // ─── Datos para gráficos ────────────────────────────────────────────────

    public function getIngresosPorDiaProperty()
    {
        $dias = $this->periodoGrafico === 'semana' ? 7 : ($this->periodoGrafico === 'mes' ? 30 : 365);

        $data = Pagos::select(
            DB::raw('DATE(fecha_pago) as fecha'),
            DB::raw('SUM(monto) as total')
        )
            ->where('estado', 'pagado')
            ->where('fecha_pago', '>=', Carbon::now()->subDays($dias))
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get()
            ->keyBy('fecha');

        $result = [];
        for ($i = $dias - 1; $i >= 0; $i--) {
            $fecha = Carbon::now()->subDays($i)->format('Y-m-d');
            $label = Carbon::now()->subDays($i)->format($dias <= 7 ? 'D' : ($dias <= 30 ? 'd/m' : 'M'));
            $result[] = [
                'fecha' => $label,
                'total' => isset($data[$fecha]) ? (float) $data[$fecha]->total : 0,
            ];
        }

        return $result;
    }

    public function getHabitacionesPorTipoProperty()
    {
        return TipoHabitacion::withCount(['habitaciones as total'])
            ->withCount(['habitaciones as ocupadas' => fn ($q) => $q->where('estado', 'ocupada')])
            ->get()
            ->map(fn ($t) => [
                'nombre' => $t->nombre,
                'total' => $t->total,
                'ocupadas' => $t->ocupadas,
            ]);
    }

    public function getMetodosPagoProperty()
    {
        return Pagos::select('metodo_pago', DB::raw('COUNT(*) as cantidad'), DB::raw('SUM(monto) as total'))
            ->where('estado', 'pagado')
            ->whereMonth('fecha_pago', Carbon::now()->month)
            ->groupBy('metodo_pago')
            ->get();
    }

    // ─── Tablas ─────────────────────────────────────────────────────────────

    public function getReservasRecientesProperty()
    {
        return Reservas::with(['cliente', 'habitacion.tipoHabitacion'])
            ->orderByDesc('created_at')
            ->take(8)
            ->get();
    }

    public function getEstanciasActivasListProperty()
    {
        return Estancia::with(['cliente', 'habitacion.tipoHabitacion'])
            ->where('estado', 'activa')
            ->orderBy('fecha_checkout')
            ->take(6)
            ->get();
    }

    public function getHabitacionesEstadoProperty()
    {
        return Habitacion::with('tipoHabitacion')
            ->orderBy('piso')
            ->orderBy('numero')
            ->take(20)
            ->get();
    }

    // ─── IA ─────────────────────────────────────────────────────────────────

    public function generarInsightIA()
    {
        if (! config('services.anthropic.key')) {
            $this->aiInsight = '⚠️ La función de IA no está configurada. Agrega tu ANTHROPIC_API_KEY en el archivo .env para activarla.';

            return;
        }

        $this->aiLoading = true;
        $this->aiInsight = '';

        $stats = $this->habitacionesStats;
        $context = "Hotel data: 
            - Habitaciones: {$stats['total']} total, {$stats['disponible']} disponibles, {$stats['ocupada']} ocupadas, {$stats['limpieza']} en limpieza
            - Ocupación: {$this->ocupacionPorcentaje}%
            - Ingresos hoy: S/. {$this->ingresosHoy}
            - Ingresos este mes: S/. {$this->ingresosMes}
            - Reservas pendientes: {$this->reservasPendientes}
            - Estancias activas: {$this->estanciasActivas}";

        $prompt = $this->aiQuery
            ? "Basándote en estos datos del hotel: {$context}\n\nResponde en español: {$this->aiQuery}"
            : "Basándote en estos datos del hotel: {$context}\n\nGenera 3 insights clave y 2 recomendaciones accionables. Responde en español, sé conciso.";

        try {
            $client = new Client;
            $response = $client->post('https://api.anthropic.com/v1/messages', [
                'headers' => [
                    'x-api-key' => config('services.anthropic.key'),
                    'anthropic-version' => '2023-06-01',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'claude-sonnet-4-20250514',
                    'max_tokens' => 600,
                    'messages' => [['role' => 'user', 'content' => $prompt]],
                ],
            ]);
            $body = json_decode($response->getBody(), true);
            $this->aiInsight = $body['content'][0]['text'] ?? 'Sin respuesta.';
        } catch (\Exception $e) {
            $this->aiInsight = '❌ Error al conectar con IA: '.$e->getMessage();
        }

        $this->aiLoading = false;
    }

    public function setPeriodo($periodo)
    {
        $this->periodoGrafico = $periodo;
    }

    public function render()
    {
        return view('livewire.dashboard', [
            'habitacionesStats' => $this->habitacionesStats,
            'ingresosMes' => $this->ingresosMes,
            'ingresosHoy' => $this->ingresosHoy,
            'ocupacionPorcentaje' => $this->ocupacionPorcentaje,
            'reservasPendientes' => $this->reservasPendientes,
            'estanciasActivas' => $this->estanciasActivas,
            'checkinsHoy' => $this->checkinsHoy,
            'checkoutsHoy' => $this->checkoutsHoy,
            'totalClientes' => $this->totalClientes,
            'clientesNuevosMes' => $this->clientesNuevosMes,
            'ingresosPorDia' => $this->ingresosPorDia,
            'habitacionesPorTipo' => $this->habitacionesPorTipo,
            'metodosPago' => $this->metodosPago,
            'reservasRecientes' => $this->reservasRecientes,
            'estanciasActivasList' => $this->estanciasActivasList,
            'habitacionesEstado' => $this->habitacionesEstado,
        ])->layout('layouts.app');
    }
}
