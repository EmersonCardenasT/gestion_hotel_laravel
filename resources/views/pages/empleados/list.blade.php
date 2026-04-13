<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Empleados') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white text-gray-900 overflow-hidden shadow-xl sm:rounded-lg p-6">

                {{-- Barra superior: buscador + botón --}}
                <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
                    <form id="searchForm" method="GET" action="{{ route('empleados.index') }}"
                        class="relative w-full max-w-xl">
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <!-- icon -->
                        </span>

                        <input id="searchInput" type="text" name="search" value="{{ request('search') }}"
                            placeholder="Buscar empleado..."
                            class="pl-10 pr-24 py-2 w-full border border-gray-300 rounded-lg text-sm text-gray-900 bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500" />

                        <button type="button" onclick="clearSearch()"
                            class="absolute inset-y-0 right-0 mr-2 inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 shadow-sm transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                            Limpiar
                        </button>
                    </form>

                    <a href="{{ route('empleados.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 
                        text-white text-sm font-medium rounded-lg shadow 
                        transition duration-150 ease-in-out">
                        Registrar Nuevo Empleado
                    </a>

                </div>

                {{-- Tabla --}}
                <div
                    class="relative overflow-x-auto bg-white text-gray-900 shadow-sm rounded-2xl border border-gray-200">
                    <table id="tablaEmpleados" class="w-full text-sm text-left text-gray-900">
                        <thead class="bg-gray-100 text-gray-900 border-b border-gray-200">
                            <tr>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Empleado
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    DNI
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Email
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Telefono
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Direccion
                                </th>
                                <th scope="col" class="px-6 py-3 font-medium">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($empleados as $empleado)
                                <tr id="empleado-{{ $empleado->id }}"
                                    class="odd:bg-white even:bg-gray-50 border-b border-gray-200 hover:bg-gray-100 transition-colors">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $empleado->id }}
                                    </th>
                                    <td class="px-6 py-4 text-gray-900">
                                        {{ $empleado->nombre }} {{ $empleado->apellido }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-900">
                                        {{ $empleado->dni }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-900">
                                        {{ $empleado->email }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-900">
                                        {{ $empleado->telefono }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-900">
                                        {{ $empleado->direccion }}
                                    </td>
                                    <td class="px-6 py-4 space-x-2">
                                        <a href="{{ route('empleados.edit', $empleado) }}"
                                            class="inline-flex items-center rounded-md border border-gray-300 bg-white px-3 py-1 text-xs font-medium text-gray-900 transition hover:bg-gray-200">
                                            <i class="fa-solid fa-pen text-indigo-600"></i>
                                        </a>
                                        <button type="button" data-id="{{ $empleado->id }}"
                                            data-nombre="{{ $empleado->nombre }} {{ $empleado->apellido }}"
                                            class="btn-delete inline-flex items-center rounded-md border border-gray-300 
                                                bg-white px-3 py-1 text-xs font-medium text-gray-900 transition hover:bg-red-100">
                                            <i class="fa-solid fa-trash text-red-600"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-gray-700">
                                        No hay empleados registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div
                    class="mt-6 flex items-center justify-between 
                    px-4 py-3 rounded-lg
                    border border-indigo-100 ">

                    <div class="text-sm text-indigo-700 dark:text-indigo-400 font-medium">
                        Mostrando {{ $empleados->firstItem() }} a {{ $empleados->lastItem() }}
                        de {{ $empleados->total() }} empleados
                    </div>

                    <div
                        class="[&>nav]:text-indigo-600 
                            [&>nav>div>span]:text-indigo-400
                            [&>nav a]:hover:text-indigo-800
                            dark:[&>nav]:text-indigo-400">
                        {{ $empleados->links() }}
                    </div>
                </div>

                <script>
                    function clearSearch() {
                        const searchInput = document.getElementById('searchInput');
                        searchInput.value = '';
                        document.getElementById('searchForm').submit();
                    }

                    document.querySelectorAll('.btn-delete').forEach(button => {

                        button.addEventListener('click', function() {

                            let id = this.dataset.id;
                            let nombre = this.dataset.nombre;

                            Swal.fire({
                                title: `¿Eliminar empleado ${nombre}?`,
                                text: "No podrás revertir esto",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#6366f1',
                                cancelButtonColor: '#6b7280',
                                confirmButtonText: 'Sí, eliminar'
                            }).then((result) => {

                                if (result.isConfirmed) {

                                    fetch(`/empleados/${id}`, {
                                            method: 'DELETE',
                                            headers: {
                                                'X-CSRF-TOKEN': document.querySelector(
                                                    'meta[name="csrf-token"]').content,
                                                'Accept': 'application/json'
                                            }
                                        })
                                        .then(res => res.json())
                                        .then(data => {

                                            if (data.success) {

                                                Swal.fire({
                                                    icon: 'success',
                                                    title: 'Eliminado',
                                                    text: data.message,
                                                    confirmButtonColor: '#6366f1'
                                                }).then(() => {
                                                    document.getElementById(`empleado-${id}`)
                                                        .remove();
                                                });

                                            } else {
                                                Swal.fire('Error', data.message, 'error');
                                            }

                                        });

                                }

                            });

                        });

                    });
                </script>

            </div>
        </div>
    </div>

</x-app-layout>
