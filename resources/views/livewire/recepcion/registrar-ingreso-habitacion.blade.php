<div>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Registrar huésped — Habitación {{ $habitacion->numero }}
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
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                            @if($habitacion->estado === 'disponible') bg-green-100 text-green-700
                            @elseif($habitacion->estado === 'ocupado') bg-red-100 text-red-700
                            @else bg-yellow-100 text-yellow-700 @endif">
                            {{ ucfirst($habitacion->estado) }}
                        </span>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                            {{ $habitacion->tipo->nombre ?? 'Estándar' }}
                        </span>
                    </div>
                </div>
                <div class="border-t border-gray-100 pt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Descripción</p>
                        <p class="text-sm text-gray-600">{{ $habitacion->descripcion ?? 'Sin descripción.' }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
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
                            <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Área</p>
                            <p class="text-sm font-medium text-gray-800">{{ $habitacion->area ?? '—' }} m²</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── SECCIÓN 2: CLIENTE ── --}}
            <p class="text-xs font-medium tracking-widest uppercase text-gray-400 mb-2">Datos del cliente</p>
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 mb-6">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-600 mb-1">
                        Seleccionar cliente <span class="text-red-500">*</span>
                    </label>
                    <div class="flex gap-2 items-end">
                        <select
                            wire:model.live="id_cliente"
                            class="flex-1 rounded-lg border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500"
                            required
                        >
                            <option value="">— Buscar cliente —</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id_cliente }}">
                                    {{ $cliente->apellidos }}, {{ $cliente->nombres }}
                                    ({{ $cliente->tipo_documento }} {{ $cliente->numero_documento }})
                                </option>
                            @endforeach
                        </select>
                        <a href="{{ route('clientes.create') }}" target="_blank"
                           class="flex items-center gap-1.5 px-4 py-2 text-sm text-gray-500 border border-gray-200 rounded-lg hover:bg-gray-50 whitespace-nowrap transition">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 16 16" stroke="currentColor">
                                <path stroke-linecap="round" stroke-width="1.5" d="M8 3v10M3 8h10"/>
                            </svg>
                            Nuevo cliente
                        </a>
                    </div>
                    @error('id_cliente') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Info cliente --}}
                @if($id_cliente)
                    @php $c = $clientes->firstWhere('id_cliente', $id_cliente); @endphp
                    @if($c)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Nombre</p>
                                <p class="text-sm font-medium text-gray-800">{{ $c->nombres }} {{ $c->apellidos }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Tipo doc.</p>
                                <p class="text-sm font-medium text-gray-800">{{ $c->tipo_documento }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Documento</p>
                                <p class="text-sm font-medium text-gray-800">{{ $c->numero_documento }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase tracking-wider mb-1">Teléfono</p>
                                <p class="text-sm font-medium text-gray-800">{{ $c->telefono ?? '—' }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                @endif
            </div>

            {{-- ── GRID DOS COLUMNAS ── --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- ── COLUMNA IZQUIERDA: DETALLE RESERVA ── --}}
                <div>
                    <p class="text-xs font-medium tracking-widest uppercase text-gray-400 mb-2">Detalle de la reserva</p>
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 mb-4">

                        {{-- Precio por noche --}}
                        <div class="bg-blue-50 border border-blue-100 rounded-lg p-3 mb-5 flex items-center justify-between">
                            <p class="text-xs text-blue-500 uppercase tracking-wider">Precio por noche</p>
                            <p class="text-xl font-bold text-blue-700">S/ {{ number_format($precio_noche, 2) }}</p>
                        </div>

                        {{-- Fechas --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">
                                    Fecha de ingreso <span class="text-red-500">*</span>
                                </label>
                                <input type="date" wire:model="fecha_ingreso"
                                    class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500"
                                    required />
                                @error('fecha_ingreso') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">
                                    Cantidad de noches <span class="text-red-500">*</span>
                                </label>
                                <div class="flex items-center gap-2">
                                    <input type="number" wire:model.live="cantidad_noches"
                                        min="1"
                                        class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500"
                                        required />
                                    <button type="button" wire:click="abrirModalExtender"
                                        title="Extender estancia"
                                        class="flex-shrink-0 p-2 border border-gray-200 rounded-lg text-gray-400 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-300 transition">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                    </button>
                                </div>
                                @error('cantidad_noches') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        {{-- Adultos y niños --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Adultos</label>
                                <input type="number" wire:model="cantidad_adultos" min="1"
                                    class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500" />
                                @error('cantidad_adultos') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Niños</label>
                                <input type="number" wire:model="cantidad_ninos" min="0"
                                    class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500" />
                            </div>
                        </div>

                        {{-- Observaciones --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Observaciones</label>
                            <textarea wire:model="observaciones" rows="2"
                                placeholder="Observaciones adicionales..."
                                class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500 resize-none">
                            </textarea>
                        </div>
                    </div>

                    {{-- ── ESTADO DEL PAGO (reemplaza "estado de reserva") ── --}}
                    <p class="text-xs font-medium tracking-widest uppercase text-gray-400 mb-2">Estado del pago</p>
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 mb-4">

                        {{-- Selector visual de estado --}}
                        <div class="grid grid-cols-2 gap-2 mb-5">
                            @php
                                $estadosPago = [
                                    'pending'   => ['label' => 'Pendiente',       'icon' => '🕐', 'color' => 'border-yellow-300 bg-yellow-50 text-yellow-700'],
                                    'partial'   => ['label' => 'Adelanto',        'icon' => '💵', 'color' => 'border-orange-300 bg-orange-50 text-orange-700'],
                                    'paid'      => ['label' => 'Pagado completo', 'icon' => '✅', 'color' => 'border-green-400 bg-green-50 text-green-700'],
                                    'checkout'  => ['label' => 'Check-out',       'icon' => '🚪', 'color' => 'border-blue-400 bg-blue-50 text-blue-700'],
                                    'cancelled' => ['label' => 'Cancelado',       'icon' => '❌', 'color' => 'border-red-300 bg-red-50 text-red-700'],
                                ];
                            @endphp
                            @foreach($estadosPago as $valor => $info)
                                <label wire:click="$set('estado_pago', '{{ $valor }}')"
                                    class="flex items-center gap-2 px-3 py-2.5 border rounded-xl cursor-pointer text-sm font-medium transition-all
                                        {{ $estado_pago === $valor ? $info['color'] . ' ring-2 ring-offset-1 ring-current' : 'border-gray-200 text-gray-500 hover:bg-gray-50' }}">
                                    <input type="radio" wire:model.live="estado_pago" value="{{ $valor }}" class="hidden" />
                                    <span>{{ $info['icon'] }}</span>
                                    {{ $info['label'] }}
                                </label>
                            @endforeach
                        </div>

                        {{-- Campo adelanto (visible solo si partial) --}}
                        @if($estado_pago === 'partial')
                        <div class="border-t border-gray-100 pt-4 space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">
                                    Monto de adelanto <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400 text-sm">S/</span>
                                    <input type="number" wire:model.live="monto_adelanto"
                                        min="0" max="{{ $subtotal }}" step="0.01"
                                        placeholder="0.00"
                                        class="w-full pl-9 rounded-lg border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500" />
                                </div>
                                @if($monto_adelanto > 0 && $monto_adelanto < $subtotal)
                                    <p class="text-xs text-orange-500 mt-1">
                                        Saldo pendiente: S/ {{ number_format($saldo, 2) }}
                                    </p>
                                @endif
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
                                    placeholder="Ej. OP-00123"
                                    class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500" />
                            </div>
                        </div>
                        @endif

                        {{-- Si pagado completo, mostrar método de pago --}}
                        @if($estado_pago === 'paid')
                        <div class="border-t border-gray-100 pt-4 grid grid-cols-2 gap-3">
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
                                <label class="block text-sm font-medium text-gray-600 mb-1">Referencia</label>
                                <input type="text" wire:model="referencia"
                                    placeholder="Opcional"
                                    class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500" />
                            </div>
                        </div>
                        @endif

                        {{-- Alerta checkout / cancelado → habitación libre --}}
                        @if(in_array($estado_pago, ['checkout', 'cancelled']))
                        <div class="mt-4 flex items-center gap-2 bg-blue-50 border border-blue-100 rounded-lg px-4 py-3 text-sm text-blue-700">
                            <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            La habitación quedará marcada como <strong class="ml-1">disponible</strong> al guardar.
                        </div>
                        @endif
                    </div>
                </div>

                {{-- ── COLUMNA DERECHA: RESUMEN + BOTONES ── --}}
                <div>
                    <p class="text-xs font-medium tracking-widest uppercase text-gray-400 mb-2">Resumen de cobro</p>
                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-5 mb-4 sticky top-4">

                        {{-- Líneas del cobro --}}
                        <div class="space-y-0 mb-4">
                            <div class="flex justify-between items-center py-2.5 border-b border-gray-100 text-sm text-gray-500">
                                <span>Precio por noche</span>
                                <span>S/ {{ number_format($precio_noche, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2.5 border-b border-gray-100 text-sm text-gray-500">
                                <span>× {{ $cantidad_noches }} {{ $cantidad_noches == 1 ? 'noche' : 'noches' }}</span>
                                <span>S/ {{ number_format($subtotal, 2) }}</span>
                            </div>

                            @if($estado_pago === 'partial' && $monto_adelanto > 0)
                            <div class="flex justify-between items-center py-2.5 border-b border-gray-100 text-sm text-orange-500">
                                <span>Adelanto registrado</span>
                                <span>− S/ {{ number_format($monto_adelanto, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2.5 border-b border-gray-100 text-sm font-medium text-red-500">
                                <span>Saldo pendiente</span>
                                <span>S/ {{ number_format($saldo, 2) }}</span>
                            </div>
                            @endif

                            @if($estado_pago === 'paid')
                            <div class="flex justify-between items-center py-2.5 border-b border-gray-100 text-sm text-green-600">
                                <span>Pago completo</span>
                                <span>S/ {{ number_format($subtotal, 2) }}</span>
                            </div>
                            @endif

                            <div class="flex justify-between items-center pt-3 text-base font-bold text-gray-900">
                                <span>Total a cobrar</span>
                                <span class="text-blue-700 text-lg">S/ {{ number_format($subtotal, 2) }}</span>
                            </div>
                        </div>

                        {{-- Badge estado habitación --}}
                        <div class="rounded-lg px-4 py-3 text-sm font-medium flex items-center justify-between
                            @if(in_array($estado_pago, ['checkout','cancelled'])) bg-green-50 text-green-700 border border-green-100
                            @elseif($estado_pago === 'pending') bg-yellow-50 text-yellow-700 border border-yellow-100
                            @elseif($estado_pago === 'partial') bg-orange-50 text-orange-700 border border-orange-100
                            @else bg-blue-50 text-blue-700 border border-blue-100 @endif">
                            <span>Estado de habitación al guardar:</span>
                            <span class="font-bold">
                                @if(in_array($estado_pago, ['checkout','cancelled']))
                                    🟢 Disponible
                                @else
                                    🔴 Ocupada
                                @endif
                            </span>
                        </div>

                        {{-- Campos ocultos --}}
                        <input type="hidden" wire:model="subtotal">
                        <input type="hidden" value="{{ $habitacion->id_habitacion }}">

                        {{-- Botones --}}
                        <div class="flex items-center justify-end gap-3 mt-5">
                            <a href="{{ route('habitaciones.index') }}"
                               class="px-5 py-2.5 text-sm text-gray-500 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                                Cancelar
                            </a>
                            <button type="button" wire:click="guardar"
                                wire:loading.attr="disabled"
                                class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition disabled:opacity-60 flex items-center gap-2">
                                <span wire:loading.remove wire:target="guardar">Registrar huésped</span>
                                <span wire:loading wire:target="guardar">Guardando...</span>
                            </button>
                        </div>
                    </div>
                </div>

            </div>{{-- fin grid --}}
        </div>
    </div>

    {{-- ── MODAL EXTENDER ESTANCIA ── --}}
    @if($mostrarModalExtender)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-semibold text-gray-900">Extender estancia</h3>
                <button wire:click="cerrarModalExtender" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <p class="text-sm text-gray-500 mb-4">
                Noches actuales: <strong>{{ $cantidad_noches }}</strong> —
                Total actual: <strong>S/ {{ number_format($subtotal, 2) }}</strong>
            </p>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-600 mb-1">
                    Noches adicionales <span class="text-red-500">*</span>
                </label>
                <input type="number" wire:model="noches_extra" min="1"
                    class="w-full rounded-lg border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500" />
                @error('noches_extra') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="bg-blue-50 rounded-lg px-4 py-3 text-sm text-blue-700 mb-5">
                Nuevo total estimado:
                <strong>S/ {{ number_format($precio_noche * ($cantidad_noches + (int)$noches_extra), 2) }}</strong>
                ({{ $cantidad_noches + (int)$noches_extra }} noches)
            </div>

            <div class="flex gap-3 justify-end">
                <button wire:click="cerrarModalExtender"
                    class="px-4 py-2 text-sm text-gray-500 border border-gray-200 rounded-lg hover:bg-gray-50">
                    Cancelar
                </button>
                <button wire:click="extenderEstancia"
                    class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                    Confirmar extensión
                </button>
            </div>
        </div>
    </div>
    @endif

</div>