<div>

    {{-- Notificación flash --}}
    @if (session()->has('mensaje'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
             class="mb-4 flex items-center gap-2 bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-3 rounded-lg">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('mensaje') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex items-start justify-between mb-6 flex-wrap gap-3">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Habitaciones</h1>
            <p class="text-sm text-gray-500 mt-1">Gestiona todas las habitaciones del hotel</p>
        </div>
        <x-button wire:click="crear" class="inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nueva Habitación
        </x-button>
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
            {{-- Botón limpiar búsqueda --}}
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

        {{-- Limpiar todos los filtros --}}
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

    {{-- Grid de habitaciones --}}
    @if($habitaciones->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 text-gray-400">
            <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/>
            </svg>
            <p class="text-sm font-medium">No se encontraron habitaciones</p>
            <p class="text-xs mt-1">Intenta cambiar los filtros o crea una nueva</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($habitaciones as $hab)
            @php
            $badgeClass = match($hab->estado) {
                'disponible'    => 'bg-green-100 text-green-800',
                'ocupado'       => 'bg-red-200 text-red-800',
                'limpieza'      => 'bg-blue-100 text-blue-800',
                'mantenimiento' => 'bg-yellow-100 text-yellow-800',
                default         => 'bg-gray-100 text-gray-700',
            };
            $badgeLabel = match($hab->estado) {
                'disponible'    => 'Disponible',
                'ocupado'       => 'Ocupado',
                'limpieza'      => 'Limpieza',
                'mantenimiento' => 'Mantenimiento',
                default         => $hab->estado,
            };
            @endphp
            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:border-gray-300 transition">

                {{-- Imagen de la habitación --}}
                @if($hab->imagen)
                    <div class="h-40 w-full overflow-hidden bg-gray-100">
                        <img
                            src="{{ Storage::url($hab->imagen) }}"
                            alt="Habitación {{ $hab->numero }}"
                            class="w-full h-full object-cover"
                        >
                    </div>
                @else
                    <div class="h-40 w-full bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14
                                   M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif

                <div class="p-5">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <p class="text-2xl font-semibold text-gray-900">{{ $hab->numero }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">Piso {{ $hab->piso }}</p>
                        </div>
                        <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $badgeClass }}">
                            {{ $badgeLabel }}
                        </span>
                    </div>
                    <div class="border-t border-gray-100 pt-3">
                        <p class="text-sm text-gray-500 mb-1">{{ $hab->tipoHabitacion->nombre ?? '—' }}</p>
                        <p class="text-lg font-semibold text-gray-900 mb-3">
                            ${{ number_format($hab->precio_base, 2) }}
                            <span class="text-xs font-normal text-gray-400">/noche</span>
                        </p>
                        @if($hab->observaciones)
                            <p class="text-xs text-gray-400 italic mb-3 line-clamp-1">{{ $hab->observaciones }}</p>
                        @endif
                        <div class="flex gap-2">
                            <button
                                wire:click="editar({{ $hab->id_habitacion }})"
                                class="flex-1 text-center text-sm border border-gray-300 rounded-lg py-1.5 hover:bg-gray-50 transition"
                            >
                                Editar
                            </button>
                            <button
                                wire:click="eliminar({{ $hab->id_habitacion }})"
                                wire:confirm="¿Estás seguro de eliminar la habitación {{ $hab->numero }}?"
                                class="flex-1 text-sm bg-red-50 text-red-700 border border-red-200 rounded-lg py-1.5 hover:bg-red-100 transition"
                            >
                                Eliminar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif

    {{-- Modal --}}
    <x-dialog-modal wire:model="open">

        <x-slot name="title">
            {{ $modo === 'crear' ? 'Nueva Habitación' : 'Editar Habitación' }}
        </x-slot>

        <x-slot name="content">
            <div class="space-y-4">

                {{-- Número y Piso --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-label value="Número" />
                        <x-input type="text" class="w-full mt-1" wire:model="numero" placeholder="101" />
                        @error('numero') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <x-label value="Piso" />
                        <x-input type="number" class="w-full mt-1" wire:model="piso" placeholder="1" min="1" />
                        @error('piso') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Tipo de Habitación --}}
                <div>
                    <x-label value="Tipo de Habitación" />
                    <select wire:model.live="tipo"
                        class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                        <option value="">Selecciona un tipo...</option>
                        @foreach($tipo_habitacion as $t)
                            <option value="{{ $t->id_tipo }}">{{ $t->nombre }} - ${{ $t->precio_base }}</option>
                        @endforeach
                    </select>
                    @error('tipo') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Precio por Noche --}}
                <div>
                    <x-label value="Precio por Noche ($)" />
                    <x-input type="number" class="w-full mt-1" wire:model="precio_base" placeholder="100" min="0" />
                    @error('precio_base') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Estado (Radio) --}}
                <div>
                    <x-label value="Estado" />
                    <div class="mt-2 grid grid-cols-2 gap-2">
                        @foreach([
                            'disponible'    => ['label' => 'Disponible',    'color' => 'green'],
                            'ocupada'       => ['label' => 'Ocupado',       'color' => 'red'],
                            'limpieza'      => ['label' => 'Limpieza',      'color' => 'blue'],
                            'mantenimiento' => ['label' => 'Mantenimiento', 'color' => 'indigo'],
                        ] as $valor => $config)
                        @php
                        $colores = [
                            'green'  => 'peer-checked:bg-green-50  peer-checked:border-green-400  peer-checked:text-green-800',
                            'red'    => 'peer-checked:bg-red-50    peer-checked:border-red-400    peer-checked:text-red-800',
                            'blue'   => 'peer-checked:bg-blue-50   peer-checked:border-blue-400   peer-checked:text-blue-800',
                            'indigo' => 'peer-checked:bg-indigo-50 peer-checked:border-indigo-400 peer-checked:text-indigo-800',
                        ];
                        $dot = [
                            'green'  => 'bg-green-500',
                            'red'    => 'bg-red-500',
                            'blue'   => 'bg-blue-500',
                            'indigo' => 'bg-indigo-400',
                        ];
                        @endphp
                        <label class="relative cursor-pointer">
                            <input type="radio" wire:model="estado" value="{{ $valor }}" class="peer sr-only" />
                            <div class="flex items-center gap-2 px-3 py-2.5 border border-gray-200 rounded-lg text-sm text-gray-600 transition-all {{ $colores[$config['color']] }}">
                                <span class="w-2.5 h-2.5 rounded-full {{ $dot[$config['color']] }}"></span>
                                {{ $config['label'] }}
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('estado') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- Observaciones --}}
                <div>
                    <x-label value="Observaciones" />
                    <textarea wire:model="observaciones" rows="3" placeholder="Notas adicionales..."
                        class="w-full mt-1 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm resize-none"></textarea>
                    @error('observaciones') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                </div>

                {{-- ── Imagen ──────────────────────────────────────────────────────── --}}
                <div x-data="{ dragging: false }" x-on:dragover.window.prevent x-on:drop.window.prevent>
                    <x-label value="Imagen de la Habitación" />

                    {{-- Preview imagen actual (modo editar, sin nueva imagen seleccionada) --}}
                    @if($imagen_actual && !$imagen && !$eliminar_imagen)
                        <div class="mt-2 mb-3 relative group w-full rounded-lg overflow-hidden border border-gray-200 bg-gray-50">
                            <img
                                src="{{ Storage::url($imagen_actual) }}"
                                alt="Imagen actual"
                                class="w-full h-44 object-cover"
                            >
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition flex items-center justify-center">
                                <span class="opacity-0 group-hover:opacity-100 text-white text-xs font-medium bg-black/50 px-2 py-1 rounded transition">
                                    Imagen actual
                                </span>
                            </div>
                        </div>
                        {{-- Checkbox para eliminar imagen --}}
                        <label class="flex items-center gap-2 text-sm text-red-600 cursor-pointer select-none mb-2">
                            <input type="checkbox" wire:model.live="eliminar_imagen" class="rounded border-gray-300 text-red-500 focus:ring-red-400" />
                            Eliminar imagen actual
                        </label>
                    @endif

                    {{-- Preview nueva imagen seleccionada --}}
                    @if($imagen)
                        <div class="mt-2 mb-3 relative w-full rounded-lg overflow-hidden border border-indigo-200 bg-gray-50">
                            <img
                                src="{{ $imagen->temporaryUrl() }}"
                                alt="Nueva imagen"
                                class="w-full h-44 object-cover"
                            >
                            <div class="absolute top-2 right-2">
                                <button
                                    type="button"
                                    wire:click="$set('imagen', null)"
                                    class="bg-white/90 hover:bg-white text-gray-600 hover:text-red-600 rounded-full p-1 shadow transition"
                                    title="Quitar imagen"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 bg-indigo-600/80 text-white text-xs text-center py-1">
                                Nueva imagen — se guardará al confirmar
                            </div>
                        </div>
                    @endif

                    {{-- Drop zone (solo si no hay nueva imagen ni imagen_actual sin eliminar) --}}
                    @if(!$imagen && ($eliminar_imagen || !$imagen_actual))
                        <label
                            for="imagen-upload"
                            class="mt-2 flex flex-col items-center justify-center w-full h-36 border-2 border-dashed rounded-lg cursor-pointer transition"
                            :class="dragging
                                ? 'border-indigo-400 bg-indigo-50'
                                : 'border-gray-300 bg-gray-50 hover:border-indigo-300 hover:bg-indigo-50'"
                            x-on:dragover.prevent="dragging = true"
                            x-on:dragleave.prevent="dragging = false"
                            x-on:drop.prevent="dragging = false"
                        >
                            <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828
                                       0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-sm text-gray-500">
                                <span class="font-medium text-indigo-600">Haz clic para subir</span>
                                o arrastra aquí
                            </p>
                            <p class="text-xs text-gray-400 mt-1">JPG, PNG o WEBP — máx. 2 MB</p>
                            <input
                                id="imagen-upload"
                                type="file"
                                wire:model="imagen"
                                accept="image/jpeg,image/png,image/webp"
                                class="hidden"
                            >
                        </label>
                    @endif

                    {{-- Botón de "cambiar imagen" cuando ya existe una imagen actual --}}
                    @if($imagen_actual && !$imagen && !$eliminar_imagen)
                        <label
                            for="imagen-upload-change"
                            class="mt-1 inline-flex items-center gap-1.5 text-sm text-indigo-600 hover:text-indigo-800 cursor-pointer"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            Cambiar imagen
                            <input
                                id="imagen-upload-change"
                                type="file"
                                wire:model="imagen"
                                accept="image/jpeg,image/png,image/webp"
                                class="hidden"
                            >
                        </label>
                    @endif

                    {{-- Indicador de carga (Livewire file upload) --}}
                    <div wire:loading wire:target="imagen" class="mt-2 flex items-center gap-2 text-sm text-indigo-600">
                        <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                        </svg>
                        Subiendo imagen...
                    </div>

                    @error('imagen') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>
                {{-- ── /Imagen ──────────────────────────────────────────────────────── --}}

            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('open', false)">Cancelar</x-secondary-button>
            <x-button class="ml-2" wire:click="guardar">
                {{ $modo === 'crear' ? 'Crear Habitación' : 'Actualizar' }}
            </x-button>
        </x-slot>

    </x-dialog-modal>

</div>