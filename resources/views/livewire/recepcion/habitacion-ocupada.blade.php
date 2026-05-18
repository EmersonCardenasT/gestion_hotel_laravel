<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Check-out — Habitación {{ $habitacion->numero }}
            </h2>
            <a href="{{ route('habitaciones.index') }}"
               class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1">
                ← Volver
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            {{-- Flash --}}
            @if(session('success'))
                <div class="mb-4 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ── BANNER ESTADO ── --}}
            <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-200 rounded-xl px-5 py-4">
                <span class="text-2xl">🔴</span>
                <div>
                    <p class="text-sm font-semibold text-red-700">Habitación actualmente ocupada</p>
                    <p class="text-xs text-red-400 mt-0.5">
                        Al confirmar el cobro, pasará a modo
                        <strong class="text-yellow-600">🧹 Limpieza</strong>.
                    </p>
                </div>
            </div>

            {{-- ── SECCIÓN 1: HABITACIÓN ── --}}
            <p class="text-xs font-medium tracking-widest uppercase text-gray-400 mb-2">Información de la habitación</p>
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 mb-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">Habitación {{ $habitacion->numero }}</h3>
                        <p class="text-sm text-gray-500 mt-0.5">
                            {{ $habitacion->tipo->nombre ?? 'Sin tipo' }} · Piso {{ $habitacion->piso ?? '—' }}
                        </p>
                    </div>
                    <div class="flex gap-2">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">
                            Ocupada
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                            {{ $habitacion->tipo->nombre ?? 'Estándar' }}
                        </span>
                    </div>
                </div>
                <div class="border-t border-gray-100 pt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Capacidad</p>
                        <p class="text-sm font-medium text-gray-800">{{ $habitacion->capacidad ?? '—' }} personas</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Camas</p>
                        <p class="text-sm font-medium text-gray-800">{{ $habitacion->camas ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Baños</p>
                        <p class="text-sm font-medium text-gray-800">{{ $habitacion->banos ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Precio / noche</p>
                        <p class="text-sm font-medium text-gray-800">S/ {{ number_format($habitacion->precio_base, 2) }}</p>
                    </div>
                </div>
            </div>

            {{-- ── SECCIÓN 2: DATOS DE LA ESTANCIA ── --}}
            <p class="text-xs font-medium tracking-widest uppercase text-gray-400 mb-2">Estancia activa</p>
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 mb-6">
                @php
                    $cliente = $estancia->cliente;
                    $noches  = $estancia->noches;
                    $checkin = \Carbon\Carbon::parse($estancia->fecha_checkin);
                    $checkout= \Carbon\Carbon::parse($estancia->fecha_checkout);
                @endphp

                {{-- Cliente --}}
                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-2">Huésped</p>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Nombre</p>
                            <p class="text-sm font-medium text-gray-800">
                                {{ $cliente->nombres ?? '—' }} {{ $cliente->apellidos ?? '' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Documento</p>
                            <p class="text-sm font-medium text-gray-800">
                                {{ $cliente->tipo_documento ?? '' }} {{ $cliente->numero_documento ?? '—' }}
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Teléfono</p>
                            <p class="text-sm font-medium text-gray-800">{{ $cliente->telefono ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 mb-1">Huéspedes</p>
                            <p class="text-sm font-medium text-gray-800">
                                {{ $estancia->adultos }} adulto(s)
                                @if($estancia->ninos > 0), {{ $estancia->ninos }} niño(s)@endif
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Fechas y noches --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Check-in</p>
                        <p class="text-sm font-medium text-gray-800">{{ $checkin->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Check-out previsto</p>
                        <p class="text-sm font-medium text-gray-800">{{ $checkout->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Noches</p>
                        <p class="text-sm font-medium text-gray-800">{{ $noches }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Tarifa / noche</p>
                        <p class="text-sm font-medium text-gray-800">S/ {{ number_format($estancia->tarifa_noche, 2) }}</p>
                    </div>
                </div>

                @if($estancia->observaciones)
                <div class="mt-4 border-t border-gray-100 pt-3">
                    <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Observaciones</p>
                    <p class="text-sm text-gray-600">{{ $estancia->observaciones }}</p>
                </div>
                @endif
            </div>

            {{-- ── GRID DOS COLUMNAS ── --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- ── COLUMNA IZQUIERDA ── --}}
                <div>

                    {{-- Historial de pagos --}}
                    <p class="text-xs font-medium tracking-widest uppercase text-gray-400 mb-2">Historial de pagos</p>
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 mb-6">
                        @if($pagos->isEmpty())
                            <p class="text-sm text-gray-400 text-center py-4">Sin pagos registrados aún.</p>
                        @else
                            <div class="space-y-2">
                                @foreach($pagos as $pago)
                                <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0">
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">
                                            {{ ucfirst($pago->tipo) }}
                                            <span class="text-xs text-gray-400 ml-1">· {{ $pago->metodo_pago }}</span>
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            {{ \Carbon\Carbon::parse($pago->fecha_pago)->format('d/m/Y H:i') }}
                                            @if($pago->referencia)
                                                · Ref: {{ $pago->referencia }}
                                            @endif
                                        </p>
                                    </div>
                                    <span class="text-sm font-semibold text-green-600">
                                        + S/ {{ number_format($pago->monto, 2) }}
                                    </span>
                                </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Mini resumen --}}
                        <div class="mt-4 pt-4 border-t border-gray-100 space-y-1.5 text-sm">
                            <div class="flex justify-between text-gray-500">
                                <span>Total estancia</span>
                                <span>S/ {{ number_format($total_estancia, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-green-600">
                                <span>Ya pagado</span>
                                <span>S/ {{ number_format($total_pagado, 2) }}</span>
                            </div>
                            <div class="flex justify-between font-bold {{ $saldo_pendiente > 0 ? 'text-red-600' : 'text-green-700' }}">
                                <span>Saldo pendiente</span>
                                <span>S/ {{ number_format($saldo_pendiente, 2) }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Cobro final --}}
                    <p class="text-xs font-medium tracking-widest uppercase text-gray-400 mb-2">Cobro al check-out</p>
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5">

                        @if($saldo_pendiente <= 0)
                            <div class="flex items-center gap-2 bg-green-50 border border-green-200 rounded-lg px-4 py-3 text-sm text-green-700 mb-4">
                                ✅ La estancia está completamente pagada. Puedes proceder al check-out.
                            </div>
                        @endif

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">
                                    Monto a cobrar ahora
                                    @if($saldo_pendiente > 0)
                                        <span class="text-red-500">*</span>
                                    @endif
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 text-sm">S/</span>
                                    <input type="number"
                                        wire:model.live="monto_pago"
                                        min="0"
                                        max="{{ $saldo_pendiente }}"
                                        step="0.01"
                                        placeholder="0.00"
                                        class="w-full pl-9 rounded-lg border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500"
                                        {{ $saldo_pendiente <= 0 ? 'disabled' : '' }}
                                    />
                                </div>
                                @error('monto_pago')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Método de pago</label>
                                <select wire:model="metodo_pago"
                                    class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500">
                                    <option value="efectivo">💵 Efectivo</option>
                                    <option value="tarjeta">💳 Tarjeta</option>
                                    <option value="transferencia">🏦 Transferencia</option>
                                    <option value="yape">📱 Yape</option>
                                    <option value="plin">📱 Plin</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Referencia / Nº operación</label>
                                <input type="text" wire:model="referencia"
                                    placeholder="Ej. OP-00123 (opcional)"
                                    class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Observaciones</label>
                                <textarea wire:model="observaciones" rows="2"
                                    placeholder="Notas del check-out..."
                                    class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500 resize-none">
                                </textarea>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── COLUMNA DERECHA: RESUMEN ── --}}
                <div>
                    <p class="text-xs font-medium tracking-widest uppercase text-gray-400 mb-2">Resumen de check-out</p>
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 sticky top-4">

                        {{-- Líneas resumen --}}
                        <div class="space-y-0 mb-5">
                            <div class="flex justify-between items-center py-2.5 border-b border-gray-100 text-sm text-gray-500">
                                <span>Tarifa por noche</span>
                                <span>S/ {{ number_format($estancia->tarifa_noche, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2.5 border-b border-gray-100 text-sm text-gray-500">
                                <span>× {{ $noches }} {{ $noches == 1 ? 'noche' : 'noches' }}</span>
                                <span>S/ {{ number_format($total_estancia, 2) }}</span>
                            </div>
                            @if($total_pagado > 0)
                            <div class="flex justify-between items-center py-2.5 border-b border-gray-100 text-sm text-green-600">
                                <span>Pagos anteriores</span>
                                <span>− S/ {{ number_format($total_pagado, 2) }}</span>
                            </div>
                            @endif
                            @if($monto_pago > 0)
                            <div class="flex justify-between items-center py-2.5 border-b border-gray-100 text-sm text-blue-600">
                                <span>Cobro ahora</span>
                                <span>S/ {{ number_format($monto_pago, 2) }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between items-center pt-3 text-base font-bold text-gray-900">
                                <span>Saldo pendiente</span>
                                <span class="{{ $saldo_pendiente > 0 ? 'text-red-600' : 'text-green-700' }} text-lg">
                                    S/ {{ number_format(max(0, $saldo_pendiente - $monto_pago), 2) }}
                                </span>
                            </div>
                        </div>

                        {{-- Badge destino habitación --}}
                        <div class="rounded-lg px-4 py-3 text-sm font-medium flex items-center justify-between bg-yellow-50 text-yellow-800 border border-yellow-200 mb-5">
                            <span>La habitación pasará a:</span>
                            <span class="font-bold">🧹 Limpieza</span>
                        </div>

                        {{-- Checklist visual --}}
                        <div class="space-y-2 mb-5">
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-2">Verificación</p>

                            <div class="flex items-center gap-2 text-sm {{ $id_cliente_ok ?? true ? 'text-green-600' : 'text-gray-400' }}">
                                <span>{{ ($estancia->cliente_id) ? '✅' : '⬜' }}</span>
                                Huésped asignado
                            </div>
                            <div class="flex items-center gap-2 text-sm {{ $saldo_pendiente <= 0 || $monto_pago >= $saldo_pendiente ? 'text-green-600' : 'text-orange-500' }}">
                                <span>{{ $saldo_pendiente <= 0 || $monto_pago >= $saldo_pendiente ? '✅' : '⚠️' }}</span>
                                {{ $saldo_pendiente <= 0 ? 'Sin saldo pendiente' : 'Saldo pendiente: S/ ' . number_format($saldo_pendiente, 2) }}
                            </div>
                            <div class="flex items-center gap-2 text-sm text-green-600">
                                <span>✅</span>
                                Check-out confirmado
                            </div>
                        </div>

                        {{-- Botones --}}
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('habitaciones.index') }}"
                               class="px-5 py-2.5 text-sm text-gray-500 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                Cancelar
                            </a>
                            <button type="button" wire:click="abrirModalConfirmar"
                                class="px-6 py-2.5 text-sm font-medium text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 transition flex items-center gap-2">
                                🧹 Cobrar y pasar a Limpieza
                            </button>
                        </div>
                    </div>
                </div>

            </div>{{-- fin grid --}}
        </div>
    </div>

    {{-- ── MODAL CONFIRMACIÓN ── --}}
    @if($mostrarModalConfirmar)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-gray-900">Confirmar check-out</h3>
                <button wire:click="cerrarModalConfirmar" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <div class="space-y-3 mb-5 text-sm text-gray-600">
                <div class="bg-gray-50 rounded-lg p-3 space-y-1">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Habitación</span>
                        <span class="font-medium text-gray-800">{{ $habitacion->numero }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Huésped</span>
                        <span class="font-medium text-gray-800">
                            {{ $estancia->cliente->nombres ?? '' }} {{ $estancia->cliente->apellidos ?? '' }}
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Noches</span>
                        <span class="font-medium text-gray-800">{{ $noches }}</span>
                    </div>
                    @if($monto_pago > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-400">Cobro ahora</span>
                        <span class="font-medium text-blue-700">S/ {{ number_format($monto_pago, 2) }}</span>
                    </div>
                    @endif
                </div>

                <div class="flex items-center gap-2 bg-yellow-50 border border-yellow-200 rounded-lg px-4 py-3 text-yellow-700 text-sm">
                    🧹 La habitación pasará a estado <strong class="ml-1">Limpieza</strong>.
                </div>
            </div>

            <div class="flex gap-3 justify-end">
                <button wire:click="cerrarModalConfirmar"
                    class="px-4 py-2 text-sm text-gray-500 border border-gray-200 rounded-lg hover:bg-gray-50">
                    Cancelar
                </button>
                <button wire:click="cobrarYLimpiar"
                    wire:loading.attr="disabled"
                    class="px-5 py-2 text-sm font-medium text-white bg-yellow-500 rounded-lg hover:bg-yellow-600 disabled:opacity-60 flex items-center gap-2">
                    <span wire:loading.remove wire:target="cobrarYLimpiar">✅ Confirmar</span>
                    <span wire:loading wire:target="cobrarYLimpiar">Procesando...</span>
                </button>
            </div>
        </div>
    </div>
    @endif

</div>