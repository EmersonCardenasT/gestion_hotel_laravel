<div class="py-6 px-4 sm:px-6 lg:px-8">

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Historial Registros Ocupaciones') }}
        </h2>
    </x-slot>

    {{-- Notificación de éxito --}}
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            class="mb-4 flex items-center gap-3 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg shadow-sm">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Tarjeta principal --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">

        {{-- Header con filtros --}}
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50 flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between">
            <div class="flex items-center gap-2">
                <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                <h3 class="text-sm font-semibold text-gray-700">Registros de Ocupaciones</h3>
            </div>
            <div class="flex flex-col sm:flex-row gap-3">
                {{-- Buscador --}}
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input
                        wire:model.live.debounce.400ms="search"
                        type="text"
                        placeholder="Buscar por cliente o habitación..."
                        class="pl-9 pr-4 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent w-full sm:w-64 bg-white"
                    />
                </div>
                {{-- Filtro de estado --}}
                <select
                    wire:model.live="estadoFiltro"
                    class="py-2 px-3 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:border-transparent bg-white text-gray-600">
                    <option value="">Todos los estados</option>
                    <option value="activo">Activo</option>
                    <option value="finalizado">Finalizado</option>
                    <option value="cancelado">Cancelado</option>
                </select>
            </div>
        </div>

        {{-- Tabla --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50/30">
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">#</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Cliente</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Habitación</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Check-in</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Check-out</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Noches</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="text-center px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($estancias as $estancia)
                        <tr class="hover:bg-indigo-50/30 transition-colors duration-150 group">
                            <td class="px-6 py-4 text-gray-400 font-mono text-xs">{{ $estancia->id }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center flex-shrink-0">
                                        <span class="text-xs font-semibold text-indigo-600">
                                            {{ strtoupper(substr($estancia->cliente->nombre ?? 'N', 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">
                                            {{ $estancia->cliente->nombre ?? '—' }} {{ $estancia->cliente->apellido ?? '' }}
                                        </p>
                                        <p class="text-xs text-gray-400">{{ $estancia->cliente->dni ?? '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center gap-1 bg-gray-100 text-gray-700 text-xs font-medium px-2.5 py-1 rounded-md">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    Hab. {{ $estancia->habitacion->numero ?? $estancia->habitacion_id }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ \Carbon\Carbon::parse($estancia->fecha_checkin)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ \Carbon\Carbon::parse($estancia->fecha_checkout)->format('d/m/Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="font-semibold text-gray-700">{{ $estancia->noches }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-semibold text-gray-800">S/. {{ number_format($estancia->total, 2) }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $estadoConfig = [
                                        'activo'     => 'bg-green-100 text-green-700 border-green-200',
                                        'finalizado' => 'bg-blue-100 text-blue-700 border-blue-200',
                                        'cancelado'  => 'bg-red-100 text-red-700 border-red-200',
                                    ];
                                    $clase = $estadoConfig[$estancia->estado] ?? 'bg-gray-100 text-gray-600 border-gray-200';
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $clase }}">
                                    {{ ucfirst($estancia->estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Botón Ver --}}
                                    <button
                                        wire:click="verDetalle({{ $estancia->id }})"
                                        title="Ver detalle"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 border border-indigo-200 rounded-lg hover:bg-indigo-100 hover:border-indigo-300 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:ring-offset-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Ver
                                    </button>
                                    {{-- Botón Eliminar --}}
                                    <button
                                        wire:click="confirmarEliminacion({{ $estancia->id }})"
                                        title="Eliminar"
                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 hover:border-red-300 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3 text-gray-400">
                                    <svg class="w-12 h-12 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <p class="text-sm font-medium">No se encontraron registros</p>
                                    <p class="text-xs">Intenta con otros criterios de búsqueda</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        @if ($estancias->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
                {{ $estancias->links() }}
            </div>
        @endif
    </div>


    {{-- ===================== MODAL VER DETALLE ===================== --}}
    @if ($modalVer && $estanciaSeleccionada)
        <div
            x-data
            x-init="$el.focus()"
            @keydown.escape.window="$wire.cerrarModal()"
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            aria-modal="true" role="dialog">

            {{-- Overlay --}}
            <div
                wire:click="cerrarModal"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

            {{-- Panel --}}
            <div
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">

                {{-- Header modal --}}
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 sticky top-0 bg-white rounded-t-2xl z-10">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-indigo-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-semibold text-gray-900">Detalle de Ocupación</h3>
                            <p class="text-xs text-gray-400">Registro #{{ $estanciaSeleccionada->id }}</p>
                        </div>
                    </div>
                    <button wire:click="cerrarModal"
                        class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Cuerpo --}}
                <div class="p-6 space-y-5">

                    {{-- Cliente --}}
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Información del Cliente</p>
                        <div class="bg-gray-50 rounded-xl p-4 grid grid-cols-2 gap-3">
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Nombre</p>
                                <p class="text-sm font-medium text-gray-800">
                                    {{ $estanciaSeleccionada->cliente->nombre ?? '—' }} {{ $estanciaSeleccionada->cliente->apellido ?? '' }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">DNI / Documento</p>
                                <p class="text-sm font-medium text-gray-800">{{ $estanciaSeleccionada->cliente->dni ?? '—' }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Estadía --}}
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Detalle de la Estadía</p>
                        <div class="bg-gray-50 rounded-xl p-4 grid grid-cols-2 gap-3">
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Habitación</p>
                                <p class="text-sm font-medium text-gray-800">N° {{ $estanciaSeleccionada->habitacion->numero ?? $estanciaSeleccionada->habitacion_id }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Reserva ID</p>
                                <p class="text-sm font-medium text-gray-800">{{ $estanciaSeleccionada->reserva_id ?? '—' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Check-in</p>
                                <p class="text-sm font-medium text-gray-800">
                                    {{ \Carbon\Carbon::parse($estanciaSeleccionada->fecha_checkin)->format('d/m/Y') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Check-out</p>
                                <p class="text-sm font-medium text-gray-800">
                                    {{ \Carbon\Carbon::parse($estanciaSeleccionada->fecha_checkout)->format('d/m/Y') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Adultos</p>
                                <p class="text-sm font-medium text-gray-800">{{ $estanciaSeleccionada->adultos }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 mb-0.5">Niños</p>
                                <p class="text-sm font-medium text-gray-800">{{ $estanciaSeleccionada->ninos }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- Facturación --}}
                    <div>
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Resumen de Cobro</p>
                        <div class="bg-gray-50 rounded-xl p-4 space-y-2">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">Tarifa por noche</span>
                                <span class="font-medium text-gray-800">S/. {{ number_format($estanciaSeleccionada->tarifa_noche, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">Noches</span>
                                <span class="font-medium text-gray-800">{{ $estanciaSeleccionada->noches }}</span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-500">Subtotal</span>
                                <span class="font-medium text-gray-800">S/. {{ number_format($estanciaSeleccionada->subtotal, 2) }}</span>
                            </div>
                            <div class="border-t border-gray-200 my-2"></div>
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-gray-700">Total</span>
                                <span class="text-lg font-bold text-indigo-600">S/. {{ number_format($estanciaSeleccionada->total, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Estado y observaciones --}}
                    <div class="grid grid-cols-1 gap-3">
                        <div class="flex items-center justify-between bg-gray-50 rounded-xl px-4 py-3">
                            <span class="text-sm text-gray-500">Estado</span>
                            @php
                                $estadoConfig = [
                                    'activo'     => 'bg-green-100 text-green-700 border-green-200',
                                    'finalizado' => 'bg-blue-100 text-blue-700 border-blue-200',
                                    'cancelado'  => 'bg-red-100 text-red-700 border-red-200',
                                ];
                                $claseModal = $estadoConfig[$estanciaSeleccionada->estado] ?? 'bg-gray-100 text-gray-600 border-gray-200';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {{ $claseModal }}">
                                {{ ucfirst($estanciaSeleccionada->estado) }}
                            </span>
                        </div>
                        @if ($estanciaSeleccionada->observaciones)
                            <div class="bg-amber-50 border border-amber-100 rounded-xl px-4 py-3">
                                <p class="text-xs font-semibold text-amber-600 mb-1">Observaciones</p>
                                <p class="text-sm text-gray-700">{{ $estanciaSeleccionada->observaciones }}</p>
                            </div>
                        @endif
                    </div>

                    {{-- Fechas sistema --}}
                    <div class="text-xs text-gray-400 flex gap-4 pt-1 border-t border-gray-100">
                        <span>Creado: {{ \Carbon\Carbon::parse($estanciaSeleccionada->created_at)->format('d/m/Y H:i') }}</span>
                        <span>Actualizado: {{ \Carbon\Carbon::parse($estanciaSeleccionada->updated_at)->format('d/m/Y H:i') }}</span>
                    </div>
                </div>

                {{-- Footer --}}
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50 rounded-b-2xl flex justify-end">
                    <button wire:click="cerrarModal"
                        class="px-5 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 hover:border-gray-300 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    @endif


    {{-- ===================== MODAL CONFIRMAR ELIMINAR ===================== --}}
    @if ($confirmarEliminar)
        <div
            @keydown.escape.window="$wire.cancelarEliminacion()"
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            aria-modal="true" role="alertdialog">

            {{-- Overlay --}}
            <div
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

            {{-- Panel --}}
            <div
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 text-center">

                {{-- Icono --}}
                <div class="w-14 h-14 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>

                <h3 class="text-lg font-bold text-gray-900 mb-2">¿Eliminar este registro?</h3>
                <p class="text-sm text-gray-500 mb-6">
                    Esta acción eliminará el registro de ocupación de forma permanente. 
                    <span class="font-medium text-gray-700">No podrá revertirse fácilmente.</span>
                </p>

                <div class="flex gap-3">
                    <button
                        wire:click="cancelarEliminacion"
                        class="flex-1 px-4 py-2.5 text-sm font-medium text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:border-gray-300 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Cancelar
                    </button>
                    <button
                        wire:click="eliminar"
                        wire:loading.attr="disabled"
                        class="flex-1 px-4 py-2.5 text-sm font-semibold text-white bg-red-500 rounded-xl hover:bg-red-600 active:scale-95 transition-all duration-150 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-1 disabled:opacity-60">
                        <span wire:loading.remove wire:target="eliminar">Sí, eliminar</span>
                        <span wire:loading wire:target="eliminar" class="flex items-center justify-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 22 6.477 22 12h-4z"/>
                            </svg>
                            Eliminando...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>