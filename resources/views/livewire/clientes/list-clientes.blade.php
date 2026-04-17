<div>

    

                {{-- BUSCADOR --}}
                <div class="mb-6">
                    <div class="relative max-w-sm">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                             xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                        </svg>
                        <input type="text" 
                                wire:model="buscar"
                                wire:keydown.enter="$refresh"
                               placeholder="Buscar por nombre o documento..."
                               class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-gray-300"/>
                    </div>
                </div>

    {{-- TABLA --}}
                <div class="border border-gray-200 rounded-xl overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 bg-white">
                                <th class="text-left px-4 py-3 text-gray-500 font-medium">Nombre</th>
                                <th class="text-left px-4 py-3 text-gray-500 font-medium">Documento</th>
                                <th class="text-left px-4 py-3 text-gray-500 font-medium">Teléfono</th>
                                <th class="text-left px-4 py-3 text-gray-500 font-medium">Email</th>
                                <th class="text-left px-4 py-3 text-gray-500 font-medium">Dirección</th>
                                <th class="text-left px-4 py-3 text-gray-500 font-medium">País</th>
                                <th class="px-4 py-3"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clientes as $cliente)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="px-4 py-3 font-medium text-gray-900">
                                    {{ $cliente->nombres }} {{ $cliente->apellidos }}
                                </td>
                                <td class="px-4 py-3 text-gray-500">
                                    {{ $cliente->tipo_documento }}: {{ $cliente->numero_documento }}
                                </td>
                                <td class="px-4 py-3 text-gray-500">{{ $cliente->telefono ?? '—' }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $cliente->email ?? '—' }}</td>
                                <td class="px-4 py-3 text-gray-500">{{ $cliente->direccion ?? '—' }}</td>
                                <td class="px-4 py-3 text-gray-900">{{ $cliente->pais }}</td>
                                <td class="px-4 py-3 text-right whitespace-nowrap">
                                    {{-- Editar --}}
                                    <a wire:navigate.hover href="{{ route('clientes.edit', $cliente->id_cliente) }}"
                                       class="inline-flex items-center justify-center p-1.5 text-indigo-500 hover:text-indigo-600 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 16 16">
                                            <path d="M11.5 1.5l3 3L5 14H2v-3L11.5 1.5z"
                                                  stroke-width="1.4" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                    {{-- Eliminar --}}
                                    <button 
                                        onclick="confirmarEliminacion({{ $cliente->id_cliente }})"
                                        class="text-red-500"
                                    >
                                    Eliminar
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

                {{-- PAGINACIÓN --}}
                @if($clientes->hasPages())
                <div class="mt-4">
                    {{ $clientes->links() }}
                </div>
                @endif

                <script>
                    function confirmarEliminacion(id) {
                            Swal.fire({
                                title: '¿Estás seguro de eliminar al ' + id + ' ?',
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
                                    @this.eliminar(id)
                                        .then(() => {
                                            Swal.fire('¡Eliminado!', 'El post ha sido borrado.', 'success');
                                        })
                                        .catch(() => {
                                            Swal.fire('Error', 'No se pudo eliminar.', 'error');
                                        });
                                }
                            })
                        }
                </script>
</div>
