<div>

 <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Recepcion') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-gray-900 overflow-hidden shadow-xl sm:rounded-lg p-6">

                {{-- Header --}}
                <div class="flex items-start justify-between mb-6 flex-wrap gap-3">
                    <div> 
                        <p class="text-sm text-gray-500 mt-1">Gestiona todas las habitaciones del hotel</p>
                    </div>
                </div>

                {{-- Filtros --}}
                <div class="flex flex-wrap gap-3 mb-6">

                    {{-- Búsqueda --}}
                    <div class="relative flex-1 min-w-[200px]">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                        </svg>
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="buscar"
                            placeholder="Buscar por número o piso..."
                            class="w-full pl-9 pr-9 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300 focus:border-blue-400 bg-white"
                        >
                        @if($buscar)
                            <button
                                wire:click="$set('buscar', '')"
                                class="absolute right-2.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition"
                                title="Limpiar búsqueda"
                            >
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        @endif
                    </div>

                    {{-- Filtro estado --}}
                    <div class="relative">
                        <select
                            wire:model.live="filtro_estado"
                            class="text-sm border border-gray-200 rounded-lg pl-3 pr-8 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-300 min-w-[170px] appearance-none"
                        >
                            <option value="">Todos los estados</option>
                            <option value="disponible">Disponible</option>
                            <option value="ocupado">Ocupado</option>
                            <option value="limpieza">Limpieza</option>
                            <option value="mantenimiento">Mantenimiento</option>
                        </select>
                        <svg class="pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>

                    {{-- Filtro piso --}}
                    <div class="relative">
                        <select
                            wire:model.live="filtro_piso"
                            class="text-sm border border-gray-200 rounded-lg pl-3 pr-8 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-300 min-w-[130px] appearance-none"
                        >
                            <option value="">Todos los pisos</option>
                            @foreach($pisos_disponibles as $p)
                                <option value="{{ $p }}">Piso {{ $p }}</option>
                            @endforeach
                        </select>
                        <svg class="pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>

                    {{-- Filtro tipo --}}
                    <div class="relative">
                        <select
                            wire:model.live="filtro_tipo"
                            class="text-sm border border-gray-200 rounded-lg pl-3 pr-8 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-blue-300 min-w-[160px] appearance-none"
                        >
                            <option value="">Todos los tipos</option>
                            @foreach($tipos_para_filtro as $t)
                                <option value="{{ $t->id_tipo }}">{{ $t->nombre }}</option>
                            @endforeach
                        </select>
                        <svg class="pointer-events-none absolute right-2.5 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>

                    {{-- Limpiar filtros --}}
                    @if($buscar || $filtro_estado || $filtro_piso || $filtro_tipo)
                        <button
                            wire:click="limpiarFiltros"
                            class="text-sm text-gray-500 hover:text-gray-800 border border-gray-200 rounded-lg px-3 py-2 hover:bg-gray-50 transition inline-flex items-center gap-1.5"
                        >
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Limpiar filtros
                        </button>
                    @endif

                </div>

                {{-- Resumen resultados --}}
                <div class="mb-4 text-xs text-gray-400">
                    {{ $habitaciones->count() }} habitación{{ $habitaciones->count() !== 1 ? 'es' : '' }} encontrada{{ $habitaciones->count() !== 1 ? 's' : '' }}
                    @if($buscar || $filtro_estado || $filtro_piso || $filtro_tipo)
                        <span class="ml-1 text-indigo-500">(con filtros activos)</span>
                    @endif
                </div>

                {{-- Grid de habitaciones — 5 columnas fijas desde md en adelante --}}
                @if($habitaciones->isEmpty())
                    <div class="flex flex-col items-center justify-center py-16 text-gray-400">
                        <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/>
                        </svg>
                        <p class="text-sm font-medium">No se encontraron habitaciones</p>
                        <p class="text-xs mt-1">Intenta cambiar los filtros o crea una nueva</p>
                    </div>
                @else
                    <div style="display:grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 0.75rem;">
                        @foreach($habitaciones as $hab)
                        @php
                        $badgeClass = match($hab->estado) {
                            'disponible'    => 'bg-green-200 text-green-800',
                            'ocupado'       => 'bg-red-200 text-red-800',
                            'limpieza'      => 'bg-blue-200 text-blue-800',
                            'mantenimiento' => 'bg-yellow-200 text-yellow-800',
                            default         => 'bg-gray-200 text-gray-700',
                        };
                        $badgeLabel = match($hab->estado) {
                            'disponible'    => 'Disponible',
                            'ocupado'       => 'Ocupado',
                            'limpieza'      => 'Limpieza',
                            'mantenimiento' => 'Mantenimiento',
                            default         => $hab->estado,
                        };
                        // Color suave de fondo del card según estado
                        $cardBg = match($hab->estado) {
                            'disponible'    => 'background-color: #86fca9; border-color: #00ff59;',
                            'ocupada'       => 'background-color: #ff7c84; border-color: #ff001e;',
                            'limpieza'      => 'background-color: #8bbcfb; border-color: #0073ff;',
                            'mantenimiento' => 'background-color: #f9ef83; border-color: #ffe100;',
                            default         => 'background-color: #fbf9fb; border-color: #e5e7eb;',
                        };
                        @endphp  

                        <button 
                            wire:click="verificarHabitacion({{ $hab->id_habitacion }}, '{{ $hab->estado }}')"
                            class="w-full text-left"
                        >
                            <div style="{{ $cardBg }}" class="border rounded-xl overflow-hidden transition group cursor-pointer hover:shadow-md hover:-translate-y-0.5 duration-200">

                                {{-- Imagen --}}
                                @if($hab->imagen)
                                    <div class="h-28 w-full overflow-hidden bg-gray-100">
                                        <img
                                            src="{{ Storage::url($hab->imagen) }}"
                                            alt="Habitación {{ $hab->numero }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition duration-300"
                                        >
                                    </div>
                                @else
                                    <div class="h-28 w-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14
                                                M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif

                                {{-- Contenido --}}
                                <div class="p-3">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <p class="text-lg font-bold text-gray-900 leading-none">{{ $hab->numero }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5">Piso {{ $hab->piso }}</p>
                                        </div>
                                        <span class="text-[10px] font-semibold px-2 py-0.5 rounded-full {{ $badgeClass }} whitespace-nowrap">
                                            {{ $badgeLabel }}
                                        </span>
                                    </div>

                                    <div class="border-t border-gray-100 pt-2 space-y-1">
                                        <p class="text-xs text-gray-500 truncate">{{ $hab->tipoHabitacion->nombre ?? '—' }}</p>
                                        <p class="text-sm font-semibold text-gray-900">
                                            ${{ number_format($hab->precio_base, 2) }}
                                            <span class="text-[10px] font-normal text-gray-400">/noche</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </button>

                        @endforeach
                    </div>
                @endif

            </div>
        </div>

        <!-- MODAL PARA CAMBIAR EL ESTADO DE LA HABITACION -->
        <x-dialog-modal wire:model="open">
            <x-slot name="title">
                Confirmar acción
            </x-slot>

            <x-slot name="content">
                {{ $mensajeConfirmacion }}
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button class="mr-2" wire:click="$set('open', false)">
                    Cancelar
                </x-secondary-button>

                <x-danger-button class="" wire:click="cambiarADisponible">
                    Sí, continuar
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>

    </div>
</div>