<div>

    <!-- {{-- Notificación flash --}} -->
    @if (session()->has('mensaje'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
             class="mb-4 flex items-center gap-2 bg-green-50 border border-green-200 text-green-800 text-sm px-4 py-3 rounded-lg">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            {{ session('mensaje') }}
        </div>
    @endif

    <!-- {{-- Header --}} -->
    <div class="flex items-start justify-between mb-6 flex-wrap gap-3">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Reservas</h1>
            <p class="text-sm text-gray-500 mt-1">Gestiona todas las reservas del hotel</p>
        </div>
        <x-button wire:click="crear" class="inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Nueva Habitación
        </x-button>
    </div>

    <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 bg-white">
                                <th class="text-left px-4 py-3 text-gray-500 font-medium">Huesped</th>
                                <th class="text-left px-4 py-3 text-gray-500 font-medium">Habitacion</th>
                                <th class="text-left px-4 py-3 text-gray-500 font-medium">Entrada</th>
                                <th class="text-left px-4 py-3 text-gray-500 font-medium">Salida</th>
                                <th class="text-left px-4 py-3 text-gray-500 font-medium">Adelanto</th>
                                <th class="text-left px-4 py-3 text-gray-500 font-medium">Total</th>
                                <th class="text-left px-4 py-3 text-gray-500 font-medium">Estado</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($reservas as $reserva)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="px-4 py-3 font-medium text-gray-900">
                                    {{ $reserva->cliente->nombres }} {{ $reserva->cliente->apellidos }}
                                </td>
                                <td class="px-4 py-3 text-gray-500">
                                    {{ $reserva->habitacion->numero }} {{ $reserva->habitacion->tipoHabitacion->nombre }}
                                </td>
                                <td class="px-4 py-3 text-gray-500">{{ $reserva->fecha_ingreso ?? '—' }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $reserva->fecha_salida ?? '—' }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $reserva->adelanto ?? '—' }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $reserva->habitacion->precio_base }}</td>
                                <td class="px-4 py-3">
                                    @if ($reserva->estado == 1)
                                        <span class="px-2 py-1 text-xs font-semibold text-indigo-700 bg-indigo-100 rounded-full">
                                            Confirmado
                                        </span>
                                    @elseif ($reserva->estado == 2)
                                        <span class="px-2 py-1 text-xs font-semibold text-green-700 bg-green-100 rounded-full">
                                            En Estadía
                                        </span>
                                    @elseif ($reserva->estado == 3)
                                        <span class="px-2 py-1 text-xs font-semibold text-gray-700 bg-gray-100 rounded-full">
                                            Finalizada
                                        </span>
                                    @elseif ($reserva->estado == 4)
                                        <span class="px-2 py-1 text-xs font-semibold text-red-700 bg-red-100 rounded-full">
                                            Cancelada
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right whitespace-nowrap space-x-2">

                                    {{-- Editar --}}
                                    <button
                                        class="inline-flex items-center justify-center p-1.5 text-indigo-500 hover:text-indigo-600 transition"
                                        title="Editar"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 16 16">
                                            <path d="M11.5 1.5l3 3L5 14H2v-3L11.5 1.5z"
                                                stroke-width="1.4" stroke-linejoin="round"/>
                                        </svg>
                                    </button>

                                    {{-- Check In (Entrando) --}}
                                    @if ($reserva->estado == 1)
                                        <button wire:click="check_in({{ $reserva->id }})"
                                            class="inline-flex items-center justify-center p-1.5 text-green-500 hover:text-green-600 transition"
                                            title="Check in"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    d="M13 5l7 7-7 7M5 12h14"/>
                                            </svg>
                                        </button>
                                    @endif

                                    {{-- Ver (Ojito) --}}
                                    <button
                                        class="inline-flex items-center justify-center p-1.5 text-gray-500 hover:text-gray-600 transition"
                                        title="Ver"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                d="M1.5 12s4-7 10.5-7 10.5 7 10.5 7-4 7-10.5 7S1.5 12 1.5 12z"/>
                                            <circle cx="12" cy="12" r="3" stroke-width="2"/>
                                        </svg>
                                    </button>

                                    {{-- Eliminar --}}
                                    <button onclick="confirmarEliminacion({{ $reserva->id }})"
                                        class="inline-flex items-center justify-center p-1.5 text-red-500 hover:text-red-600 transition"
                                        title="Eliminar"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7"/>
                                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                d="M10 11v6M14 11v6"/>
                                            <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                d="M9 7V4h6v3M4 7h16"/>
                                        </svg>
                                    </button>

                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-400 text-sm">
                                    No hay huéspedes registrados.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

    <!-- MODAL -->
    <x-dialog-modal wire:model="open">

        <x-slot name="title">
            Nueva Reserva
        </x-slot>
    
        <x-slot name="content">
            <div class="space-y-4">

            {{-- Cliente --}}
            <div>
                <x-label for="id_cliente" value="Cliente" />
                <div class="flex items-center gap-2 mt-1">
                    <select wire:model.live="id_cliente" id="id_cliente"
                        class="block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Seleccione un cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id_cliente }}">{{ $cliente->nombres }} {{ $cliente->apellidos }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('clientes.create') }}"  
                        title="Registrar nuevo cliente"
                        class="flex-shrink-0 inline-flex items-center justify-center w-9 h-9 rounded-md border border-gray-300 bg-white text-gray-600 hover:bg-indigo-50 hover:border-indigo-400 hover:text-indigo-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </a>
                </div>
                <x-input-error for="id_cliente" class="mt-2" />
            </div>

                {{-- Fechas en una fila --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-label for="fecha_ingreso" value="Fecha de Ingreso" />
                        <x-input wire:model="fecha_ingreso" id="fecha_ingreso" type="date" class="block mt-1 w-full" />
                        <x-input-error for="fecha_ingreso" class="mt-2" />
                    </div>
                    <div>
                        <x-label for="fecha_salida" value="Fecha de Salida" />
                        <x-input wire:model="fecha_salida" id="fecha_salida" type="date" class="block mt-1 w-full" />
                        <x-input-error for="fecha_salida" class="mt-2" />
                    </div>
                </div>

                {{-- Habitación --}}
                <div>
                    <x-label for="id_habitacion" value="Habitación" />
                    <select wire:model.live="id_habitacion" id="id_habitacion"
                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        <option value="">Seleccione una habitación</option>
                        @foreach($habitaciones as $habitacion)
                            <option value="{{ $habitacion->id_habitacion }}">{{ $habitacion->numero }} - {{ $habitacion->tipoHabitacion->nombre }}</option>
                        @endforeach
                    </select>
                    <x-input-error for="id_habitacion" class="mt-2" />
                </div>

                {{-- Huéspedes y Adelanto en una fila --}}
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-label for="numero_huespedes" value="N.° Huéspedes" />
                        <x-input wire:model="numero_huespedes" id="numero_huespedes" type="number" class="block mt-1 w-full" />
                        <x-input-error for="numero_huespedes" class="mt-2" />
                    </div>
                    <div>
                        <x-label for="adelanto" value="Adelanto (S/.)" />
                        <x-input wire:model="adelanto" id="adelanto" type="number" step="0.01" class="block mt-1 w-full" />
                        <x-input-error for="adelanto" class="mt-2" />
                    </div>
                </div>

                {{-- Notas --}}
                <div>
                    <x-label for="notas" value="Notas" />
                    <textarea wire:model="notas" id="notas" rows="2"
                        class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"></textarea>
                    <x-input-error for="notas" class="mt-2" />
                </div>

            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$set('open', false)">Cancelar</x-secondary-button>
            <x-button class="ml-2" wire:click="guardar">
                Registrar Reserva
            </x-button>
        </x-slot>

    </x-dialog-modal>

                <script>
                    function confirmarEliminacion(id) {
                            Swal.fire({
                                title: '¿Estás seguro de eliminar la reserva ' + id + ' ?',
                                text: "¡No podrás revertir esta acción!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Sí, eliminar',
                                cancelButtonText: 'Cancelar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Llamamos al método del componente Livewire
                                    @this.eliminar_reserva(id)
                                        .then(() => {
                                            Swal.fire('¡Eliminado!', 'La reserva ha sido eliminado.', 'success');
                                        })
                                        .catch(() => {
                                            Swal.fire('Error', 'No se pudo eliminar.', 'error');
                                        });
                                }
                            })
                        }
                </script>

</div>